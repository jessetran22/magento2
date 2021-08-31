<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-14720: Add 11 Simple product to the cart and check cart display with default display limit")
 * @Description("Add 11 Simple product to the cart and check cart display with default display limit<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckCartItemDisplayWhenMoreItemsAddedToTheCartThanDefaultDisplayLimitTest.xml<br>")
 * @TestCaseId("MC-14720")
 * @group mtf_migrated
 */
class StorefrontCheckCartItemDisplayWhenMoreItemsAddedToTheCartThanDefaultDisplayLimitTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$enableFlatRateDefaultPrice = $I->magentoCLI("config:set carriers/flatrate/price 5.00", 60); // stepKey: enableFlatRateDefaultPrice
		$I->comment($enableFlatRateDefaultPrice);
		$I->comment("Create  simple product");
		$simpleProduct1Fields['price'] = "10.00";
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], $simpleProduct1Fields); // stepKey: simpleProduct1
		$simpleProduct2Fields['price'] = "20.00";
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], $simpleProduct2Fields); // stepKey: simpleProduct2
		$simpleProduct3Fields['price'] = "30.00";
		$I->createEntity("simpleProduct3", "hook", "SimpleProduct2", [], $simpleProduct3Fields); // stepKey: simpleProduct3
		$simpleProduct4Fields['price'] = "40.00";
		$I->createEntity("simpleProduct4", "hook", "SimpleProduct2", [], $simpleProduct4Fields); // stepKey: simpleProduct4
		$simpleProduct5Fields['price'] = "50.00";
		$I->createEntity("simpleProduct5", "hook", "SimpleProduct2", [], $simpleProduct5Fields); // stepKey: simpleProduct5
		$simpleProduct6Fields['price'] = "60.00";
		$I->createEntity("simpleProduct6", "hook", "SimpleProduct2", [], $simpleProduct6Fields); // stepKey: simpleProduct6
		$simpleProduct7Fields['price'] = "70.00";
		$I->createEntity("simpleProduct7", "hook", "SimpleProduct2", [], $simpleProduct7Fields); // stepKey: simpleProduct7
		$simpleProduct8Fields['price'] = "80.00";
		$I->createEntity("simpleProduct8", "hook", "SimpleProduct2", [], $simpleProduct8Fields); // stepKey: simpleProduct8
		$simpleProduct9Fields['price'] = "90.00";
		$I->createEntity("simpleProduct9", "hook", "SimpleProduct2", [], $simpleProduct9Fields); // stepKey: simpleProduct9
		$simpleProduct10Fields['price'] = "100.00";
		$I->createEntity("simpleProduct10", "hook", "SimpleProduct2", [], $simpleProduct10Fields); // stepKey: simpleProduct10
		$simpleProduct11Fields['price'] = "110.00";
		$I->createEntity("simpleProduct11", "hook", "SimpleProduct2", [], $simpleProduct11Fields); // stepKey: simpleProduct11
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("simpleProduct4", "hook"); // stepKey: deleteProduct4
		$I->deleteEntity("simpleProduct5", "hook"); // stepKey: deleteProduct5
		$I->deleteEntity("simpleProduct6", "hook"); // stepKey: deleteProduct6
		$I->deleteEntity("simpleProduct7", "hook"); // stepKey: deleteProduct7
		$I->deleteEntity("simpleProduct8", "hook"); // stepKey: deleteProduct8
		$I->deleteEntity("simpleProduct9", "hook"); // stepKey: deleteProduct9
		$I->deleteEntity("simpleProduct10", "hook"); // stepKey: deleteProduct10
		$I->deleteEntity("simpleProduct11", "hook"); // stepKey: deleteProduct11
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Stories({"Shopping Cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckCartItemDisplayWhenMoreItemsAddedToTheCartThanDefaultDisplayLimitTest(AcceptanceTester $I)
	{
		$I->comment("Open Product1 page in StoreFront");
		$I->comment("Entering Action Group [openProduct1PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct1PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct1PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct1', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct1PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct1PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct1', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct1PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct1PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product1 to the cart");
		$I->comment("Entering Action Group [addProduct1ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct1ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct1ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct1ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct1ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct1ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct1ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct1ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct1ToTheCart
		$I->comment("Exiting Action Group [addProduct1ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product2 page in StoreFront");
		$I->comment("Entering Action Group [openProduct2PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct2PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct2PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct2', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct2PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct2', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct2PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct2', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct2PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct2PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product2 to the cart");
		$I->comment("Entering Action Group [addProduct2ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct2ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct2ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct2ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct2ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct2ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct2ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct2ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct2ToTheCart
		$I->comment("Exiting Action Group [addProduct2ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product3 page in StoreFront");
		$I->comment("Entering Action Group [openProduct3PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct3', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct3PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct3PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct3', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct3PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct3', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct3PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct3', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct3PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct3PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product3 to the cart");
		$I->comment("Entering Action Group [addProduct3ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct3ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct3ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct3ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct3ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct3ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct3ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct3ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct3', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct3ToTheCart
		$I->comment("Exiting Action Group [addProduct3ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product4 page in StoreFront");
		$I->comment("Entering Action Group [openProduct4PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct4', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct4PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct4PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct4', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct4PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct4', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct4PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct4', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct4PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct4PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product4 to the cart");
		$I->comment("Entering Action Group [addProduct4ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct4ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct4ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct4ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct4ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct4ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct4ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct4ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct4', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct4ToTheCart
		$I->comment("Exiting Action Group [addProduct4ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product5 page in StoreFront");
		$I->comment("Entering Action Group [openProduct5PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct5', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct5PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct5PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct5', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct5PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct5', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct5PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct5', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct5PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct5PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product5 to the cart");
		$I->comment("Entering Action Group [addProduct5ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct5ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct5ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct5ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct5ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct5ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct5ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct5ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct5', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct5ToTheCart
		$I->comment("Exiting Action Group [addProduct5ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product6 page in StoreFront");
		$I->comment("Entering Action Group [openProduct6PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct6', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct6PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct6PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct6', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct6PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct6', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct6PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct6', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct6PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct6PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product6 to the cart");
		$I->comment("Entering Action Group [addProduct6ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct6ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct6ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct6ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct6ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct6ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct6ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct6ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct6', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct6ToTheCart
		$I->comment("Exiting Action Group [addProduct6ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product7 page in StoreFront");
		$I->comment("Entering Action Group [openProduct7PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct7', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct7PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct7PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct7', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct7PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct7', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct7PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct7', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct7PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct7PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product7 to the cart");
		$I->comment("Entering Action Group [addProduct7ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct7ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct7ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct7ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct7ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct7ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct7ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct7ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct7', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct7ToTheCart
		$I->comment("Exiting Action Group [addProduct7ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product8 page in StoreFront");
		$I->comment("Entering Action Group [openProduct8PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct8', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct8PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct8PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct8', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct8PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct8', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct8PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct8', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct8PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct8PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product8 to the cart");
		$I->comment("Entering Action Group [addProduct8ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct8ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct8ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct8ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct8ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct8ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct8ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct8ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct8', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct8ToTheCart
		$I->comment("Exiting Action Group [addProduct8ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product9 page in StoreFront");
		$I->comment("Entering Action Group [openProduct9PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct9', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct9PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct9PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct9', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct9PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct9', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct9PageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct9', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct9PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct9PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product9 to the cart");
		$I->comment("Entering Action Group [addProduct9ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct9ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct9ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct9ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct9ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct9ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct9ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct9ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct9', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct9ToTheCart
		$I->comment("Exiting Action Group [addProduct9ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product10 page in StoreFront");
		$I->comment("Entering Action Group [openProductPage10AndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct10', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPage10AndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPage10AndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct10', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPage10AndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct10', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPage10AndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct10', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPage10AndVerifyProduct
		$I->comment("Exiting Action Group [openProductPage10AndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product10 to the cart");
		$I->comment("Entering Action Group [addProduct10ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct10ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct10ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct10ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct10ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct10ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct10ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct10ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct10', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct10ToTheCart
		$I->comment("Exiting Action Group [addProduct10ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product11 page in StoreFront");
		$I->comment("Entering Action Group [openProductPage11AndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct11', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPage11AndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPage11AndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct11', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPage11AndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct11', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPage11AndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct11', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPage11AndVerifyProduct
		$I->comment("Exiting Action Group [openProductPage11AndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product11 to the cart");
		$I->comment("Entering Action Group [addProduct11ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct11ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct11ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct11ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct11ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct11ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct11ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct11ToTheCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct11', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct11ToTheCart
		$I->comment("Exiting Action Group [addProduct11ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Assert Product details in Mini Cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [seeProductCountInMiniCart] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']", 60); // stepKey: waitForElementVisibleSeeProductCountInMiniCart
		$I->see("11", "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertElementSeeProductCountInMiniCart
		$I->comment("Exiting Action Group [seeProductCountInMiniCart] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeTotalNumberOfItemDisplayed] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//div[@class='items-total']", 60); // stepKey: waitForElementVisibleSeeTotalNumberOfItemDisplayed
		$I->see("10 of 11 Items in Cart", "//div[@class='items-total']"); // stepKey: assertElementSeeTotalNumberOfItemDisplayed
		$I->comment("Exiting Action Group [seeTotalNumberOfItemDisplayed] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeViewAndEditLink] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSeeViewAndEditLink
		$I->scrollTo(".action.viewcart"); // stepKey: scrollToElementSeeViewAndEditLink
		$I->waitForPageLoad(30); // stepKey: scrollToElementSeeViewAndEditLinkWaitForPageLoad
		$I->seeElement(".action.viewcart"); // stepKey: assertElementSeeViewAndEditLink
		$I->waitForPageLoad(30); // stepKey: assertElementSeeViewAndEditLinkWaitForPageLoad
		$I->comment("Exiting Action Group [seeViewAndEditLink] AssertStorefrontSeeElementActionGroup");
		$I->comment("Assert Product1 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct1InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$10.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct1InMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct1InMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct1InMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct1InMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct1InMiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct1InMiniCart
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct1InMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct1InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product2 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct2InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$20.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct2InMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct2InMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct2InMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct2InMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct2InMiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct2InMiniCart
		$I->see($I->retrieveEntityField('simpleProduct2', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct2InMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct2InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product3 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$30.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct3MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct3', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct3MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct3MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct3MiniCart
		$I->see($I->retrieveEntityField('simpleProduct3', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct3MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product4 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct4InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$40.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct4InMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct4InMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct4InMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct4', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct4InMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct4InMiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct4InMiniCart
		$I->see($I->retrieveEntityField('simpleProduct4', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct4InMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct4InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product5 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct5InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$50.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct5InMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct5InMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct5InMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct5', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct5InMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct5InMiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct5InMiniCart
		$I->see($I->retrieveEntityField('simpleProduct5', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct5InMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct5InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product6 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct6InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$60.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct6InMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct6InMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct6InMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct6', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct6InMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct6InMiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct6InMiniCart
		$I->see($I->retrieveEntityField('simpleProduct6', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct6InMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct6InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product7 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct7InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$70.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct7InMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct7InMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct7InMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct7', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct7InMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct7InMiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct7InMiniCart
		$I->see($I->retrieveEntityField('simpleProduct7', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct7InMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct7InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product8 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct8InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$80.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct8InMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct8InMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct8InMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct8', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct8InMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct8InMiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct8InMiniCart
		$I->see($I->retrieveEntityField('simpleProduct8', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct8InMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct8InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product9 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct9InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$90.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct9InMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct9InMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct9InMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct9', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct9InMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct9InMiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct9InMiniCart
		$I->see($I->retrieveEntityField('simpleProduct9', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct9InMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct9InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product10 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct10InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$100.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct10InMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct10InMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct10InMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct10', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct10InMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct10InMiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct10InMiniCart
		$I->see($I->retrieveEntityField('simpleProduct10', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct10InMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct10InMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Verify  Product11 is not displayed in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct11IsNotInMiniCart] AssertStorefrontMiniCartProductDetailsAbsentActionGroup");
		$I->dontSee("$110.00", "//header//ol[@id='mini-cart']//div[@class='product-item-details'][.//a[contains(text(), '" . $I->retrieveEntityField('simpleProduct11', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: dontSeeProductPriceInMiniCartAssertSimpleProduct11IsNotInMiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct11IsNotInMiniCart] AssertStorefrontMiniCartProductDetailsAbsentActionGroup");
	}
}
