'use strict';

const { Contract } = require('fabric-contract-api');

class BloodChainContract extends Contract {
    async initLedger(ctx) {
        console.log('Initializing the ledger with some blood bags.');

        const bloodBags = [
            {
                id: "1",
                donorID: "5",
                possessorID: "1",
                bloodType: 'A+',
                donationDate: '20/2/2023',
                expiration: '27/2/2023',
                status: 'laboratory',
            },
            {
                id: "2",
                donorID: "8",
                possessorID: "3",
                bloodType: 'B+',
                donationDate: '20/2/2023',
                expiration: '27/2/2023',
                status: 'laboratory',
            },
            {
                id: "3",
                donorID: "12",
                possessorID: "1",
                bloodType: 'B+',
                donationDate: '20/2/2023',
                expiration: '27/2/2023',
                status: 'laboratory',
            },
            {
                id: "4",
                donorID: "3",
                possessorID: "4",
                bloodType: 'B+',
                donationDate: '20/2/2023',
                expiration: '27/2/2023',
                status: 'laboratory',
            },
            {
                id: "5",
                donorID: "7",
                possessorID: "2",
                bloodType: 'O+',
                donationDate: '22/2/2023',
                expiration: '1/3/2023',
                status: 'laboratory',
            },
            {
                id: "6",
                donorID: "1",
                possessorID: "5",
                bloodType: 'AB+',
                donationDate: '23/2/2023',
                expiration: '2/3/2023',
                status: 'laboratory',
            },
            {
                id: "7",
                donorID: "6",
                possessorID: "4",
                bloodType: 'B-',
                donationDate: '23/2/2023',
                expiration: '2/3/2023',
                status: 'laboratory',
            },
            {
                id: "8",
                donorID: "15",
                possessorID: "1",
                bloodType: 'A-',
                donationDate: '24/2/2023',
                expiration: '3/3/2023',
                status: 'laboratory',
            },
            {
                id: "9",
                donorID: "2",
                possessorID: "3",
                bloodType: 'O-',
                donationDate: '25/2/2023',
                expiration: '4/3/2023',
                status: 'laboratory',
            },
            {
                id: "10",
                donorID: "10",
                possessorID: "2",
                bloodType: 'B+',
                donationDate: '25/2/2023',
                expiration: '4/3/2023',
                status: 'laboratory',
            },
            {
                id: "11",
                donorID: "4",
                possessorID: "5",
                bloodType: 'AB+',
                donationDate: '26/2/2023',
                expiration: '5/3/2023',
                status: 'laboratory',
            },
            {
                id: "12",
                donorID: "9",
                possessorID: "1",
                bloodType: 'A-',
                donationDate: '26/2/2023',
                expiration: '5/3/2023',
                status: 'laboratory',
            },
            {
                id: "13",
                donorID: "13",
                possessorID: "4",
                bloodType: 'B-',
                donationDate: '27/2/2023',
                expiration: '6/3/2023',
                status: 'laboratory',
            },
            {
                id: "14",
                donorID: "11",
                possessorID: "3",
                bloodType: 'AB+',
                donationDate: '27/2/2023',
                expiration: '6/3/2023',
                status: 'laboratory',
            },
            {
                id: "15",
                donorID: "1",
                possessorID: "2",
                bloodType: 'O+',
                donationDate: '28/2/2023',
                expiration: '7/3/2023',
                status: 'laboratory',
            },
            {
                id: "16",
                donorID: "5",
                possessorID: "3",
                bloodType: 'B+',
                donationDate: '1/3/2023',
                expiration: '8/3/2023',
                status: 'laboratory',
            },
            {
                id: "17",
                donorID: "14",
                possessorID: "1",
                bloodType: 'A-',
                donationDate: '2/3/2023',
                expiration: '9/3/2023',
                status: 'laboratory',
            },
            {
                id: "18",
                donorID: "8",
                possessorID: "4",
                bloodType: 'O+',
                donationDate: '3/3/2023',
                expiration: '10/3/2023',
                status: 'laboratory',
            },
            {
                id: "19",
                donorID: "3",
                possessorID: "2",
                bloodType: 'B-',
                donationDate: '3/3/2023',
                expiration: '10/3/2023',
                status: 'laboratory',
            },
            {
                id: "20",
                donorID: "12",
                possessorID: "5",
                bloodType: 'AB+',
                donationDate: '4/3/2023',
                expiration: '11/3/2023',
                status: 'laboratory',
            },
        ];

        for (let i = 0; i < bloodBags.length; i++) {
            await ctx.stub.putState(`${bloodBags[i].id}`, Buffer.from(JSON.stringify(bloodBags[i])));
            console.log(`Blood bag ${bloodBags[i].id} initialized.`);
        }

        console.log('Ledger initialized successfully.');
    }

    async initCount(ctx) {
        console.log('Initializing the ledger...');

        // Initialize the blood bag count in the world state
        await ctx.stub.putState('bloodBagCount', Buffer.from('0'));

        console.log('Ledger initialized successfully.');
    }

    async getBloodBag(ctx, bagId) {
        const bagJSON = await ctx.stub.getState(bagId);

        if (!bagJSON || bagJSON.length === 0) {
            throw new Error(`Blood bag ${bagId} does not exist.`);
        }

        return bagJSON.toString();
    }

    async getBloodBagById(ctx, id) {
        const iterator = await ctx.stub.getStateByRange('', '');

        let result = await iterator.next();
        while (!result.done) {
            const strValue = Buffer.from(result.value.value.toString()).toString('utf8');
            let record;
            try {
                record = JSON.parse(strValue);
            } catch (err) {
                console.log(err);
                record = strValue;
            }

            if (record.id === id) {
                console.log(`Blood bag with ID ${id} found.`);
                return record;
            }

            result = await iterator.next();
        }

        throw new Error(`Blood bag with ID ${id} not found.`);
    }

    async createBloodBag(ctx, donorID, possessorID, bloodType, donationDate, expiration, status) {
        // Get the latest blood bag ID from the world state
        const bloodBagCountBuffer = await ctx.stub.getState('bloodBagCount');
        if (!bloodBagCountBuffer || bloodBagCountBuffer.length === 0) {
            throw new Error('Blood bag count not found in the world state.');
        }
        const bloodBagCount = Number(bloodBagCountBuffer.toString());

        // Generate a new ID by incrementing the latest blood bag ID
        const newId = bloodBagCount + 1;

        // Create a new blood bag with the generated ID
        const newBloodBag = {
            id: newId.toString(),
            donorID: donorID,
            possessorID: possessorID,
            bloodType: bloodType,
            donationDate: donationDate,
            expiration: expiration,
            status: status
        };

        // Store the new blood bag in the world state
        const bloodBagBuffer = Buffer.from(JSON.stringify(newBloodBag));
        await ctx.stub.putState('bloodBag' + newBloodBag.id, bloodBagBuffer);

        // Update the blood bag count in the world state
        await ctx.stub.putState('bloodBagCount', Buffer.from(newId.toString()));

        console.log(`Blood bag ${newBloodBag.id} created successfully.`);

        return newBloodBag;
    }

    // GetAllAssets returns all assets found in the world state.
    async GetAllAssets(ctx) {
        const allResults = [];
        // range query with empty string for startKey and endKey does an open-ended query of all assets in the chaincode namespace.
        const iterator = await ctx.stub.getStateByRange('', '');
        let result = await iterator.next();
        while (!result.done) {
            const strValue = Buffer.from(result.value.value.toString()).toString('utf8');
            let record;
            try {
                record = JSON.parse(strValue);
            } catch (err) {
                console.log(err);
                record = strValue;
            }
            allResults.push(record);
            result = await iterator.next();
        }
        return JSON.stringify(allResults);
    }

    async getAssetHistory(ctx, assetId) {
        const resultsIterator = await ctx.stub.getHistoryForKey(assetId);

        const allResults = [];
        let res = await resultsIterator.next();

        while (!res.done) {
            if (res.value && res.value.value.toString()) {
                const strValue = Buffer.from(res.value.value.toString()).toString('utf8');
                let record;
                try {
                    record = JSON.parse(strValue);
                } catch (err) {
                    console.log(err);
                    record = strValue;
                }
                allResults.push(record);
            }
            res = await resultsIterator.next();
        }

        await resultsIterator.close();

        return JSON.stringify(allResults);
    }

    async getBloodBagsByDonorID(ctx, donorID) {
        const iterator = await ctx.stub.getStateByRange('', '');

        const allResults = [];
        let result = await iterator.next();
        while (!result.done) {
            const strValue = Buffer.from(result.value.value.toString()).toString('utf8');
            let record;
            try {
                record = JSON.parse(strValue);
            } catch (err) {
                console.log(err);
                record = strValue;
            }

            if (record.donorID === donorID) {
                allResults.push(record);
            }

            result = await iterator.next();
        }

        return JSON.stringify(allResults);
    }

    async updateBloodBagPossessor(ctx, bagId, newPossessor) {
        // Retrieve the blood bag record from the world state
        const bloodBagBuffer = await ctx.stub.getState('bloodBag' + bagId);
        if (!bloodBagBuffer || bloodBagBuffer.length === 0) {
            throw new Error(`Blood bag ${bagId} does not exist.`);
        }
        const bloodBag = JSON.parse(bloodBagBuffer.toString());

        // Update the status field of the blood bag record
        bloodBag.possessorID = newPossessor;

        // Save the updated blood bag record to the world state
        const updatedBloodBagBuffer = Buffer.from(JSON.stringify(bloodBag));
        await ctx.stub.putState('bloodBag' + bagId, updatedBloodBagBuffer);

        console.log(`Blood bag ${bagId} status updated to ${newPossessor} successfully.`);
    }

    async updateBloodBagStatus(ctx, bagId, newStatus) {
        // Retrieve the blood bag record from the world state
        const bloodBagBuffer = await ctx.stub.getState('bloodBag' + bagId);
        if (!bloodBagBuffer || bloodBagBuffer.length === 0) {
            throw new Error(`Blood bag ${bagId} does not exist.`);
        }
        const bloodBag = JSON.parse(bloodBagBuffer.toString());

        // Update the status field of the blood bag record
        bloodBag.status = newStatus;

        // Save the updated blood bag record to the world state
        const updatedBloodBagBuffer = Buffer.from(JSON.stringify(bloodBag));
        await ctx.stub.putState('bloodBag' + bagId, updatedBloodBagBuffer);

        console.log(`Blood bag ${bagId} status updated to ${newStatus} successfully.`);
    }

    async getBloodBagsByPossessorID(ctx, possessorID) {
        const iterator = await ctx.stub.getStateByRange('', '');

        const allResults = [];
        let result = await iterator.next();
        while (!result.done) {
            const strValue = Buffer.from(result.value.value.toString()).toString('utf8');
            let record;
            try {
                record = JSON.parse(strValue);
            } catch (err) {
                console.log(err);
                record = strValue;
            }

            if (record.possessorID === possessorID) {
                allResults.push(record);
            }

            result = await iterator.next();
        }

        return JSON.stringify(allResults);
    }
}


module.exports = BloodChainContract;