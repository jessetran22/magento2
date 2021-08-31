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
 * @Title("MC-14723: Add 10 SimpleProducts to the cart and check cart display with default display limit")
 * @Description("Add 10 SimpleProducts to the cart and check cart display with default display limit<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckSimpleProductCartItemDisplayWithDefaultLimitationTest.xml<br>")
 * @TestCaseId("MC-14723")
 * @group mtf_migrated
 */
class StorefrontCheckSimpleProductCartItemDisplayWithDefaultLimitationTestCest
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
	public function StorefrontCheckSimpleProductCartItemDisplayWithDefaultLimitationTest(AcceptanceTester $I)
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
		$I->comment("Open Mini Cart");
		$I->comment("Entering Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart
		$I->comment("Exiting Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->comment("Assert Product Count in Mini Cart");
		$I->comment("Entering Action Group [assertProductCountAndTextInMiniCart] StorefrontAssertMiniCartItemCountActionGroup");
		$I->see("11", "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: seeProductCountInCartAssertProductCountAndTextInMiniCart
		$I->see("10 of 11 Items in Cart", "//div[@class='items-total']"); // stepKey: seeNumberOfItemDisplayInMiniCartAssertProductCountAndTextInMiniCart
		$I->comment("Exiting Action Group [assertProductCountAndTextInMiniCart] StorefrontAssertMiniCartItemCountActionGroup");
		$I->comment("Assert Product1 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct11MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$10.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct11MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct11MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct11MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct11MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct11MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct11MiniCart
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct11MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct11MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product2 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct2MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$20.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct2MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct2MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct2MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct2MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct2MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct2MiniCart
		$I->see($I->retrieveEntityField('simpleProduct2', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct2MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct2MiniCart] AssertStorefrontMiniCartItemsActionGroup");
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
		$I->comment("Entering Action Group [assertSimpleProduct4MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$40.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct4MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct4MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct4MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct4', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct4MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct4MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct4MiniCart
		$I->see($I->retrieveEntityField('simpleProduct4', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct4MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct4MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product5 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct5MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$50.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct5MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct5MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct5MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct5', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct5MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct5MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct5MiniCart
		$I->see($I->retrieveEntityField('simpleProduct5', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct5MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct5MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product6 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct6MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$60.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct6MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct6MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct6MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct6', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct6MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct6MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct6MiniCart
		$I->see($I->retrieveEntityField('simpleProduct6', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct6MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct6MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product7 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct7MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$70.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct7MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct7MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct7MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct7', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct7MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct7MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct7MiniCart
		$I->see($I->retrieveEntityField('simpleProduct7', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct7MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct7MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product8 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct8MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$80.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct8MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct8MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct8MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct8', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct8MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct8MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct8MiniCart
		$I->see($I->retrieveEntityField('simpleProduct8', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct8MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct8MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product9 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct9MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$90.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct9MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct9MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct9MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct9', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct9MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct9MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct9MiniCart
		$I->see($I->retrieveEntityField('simpleProduct9', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct9MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct9MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product10 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct10MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$100.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct10MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct10MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct10MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simpleProduct10', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct10MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct10MiniCart
		$I->see("$660.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct10MiniCart
		$I->see($I->retrieveEntityField('simpleProduct10', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct10MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct10MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Order Summary");
		$I->comment("Entering Action Group [AssertItemsCountInOrderSummary] StorefrontCheckoutAndAssertOrderSummaryDisplayActionGroup");
		$I->click("#top-cart-btn-checkout"); // stepKey: clickOnCheckOutButtonInMiniCartAssertItemsCountInOrderSummary
		$I->waitForPageLoad(30); // stepKey: clickOnCheckOutButtonInMiniCartAssertItemsCountInOrderSummaryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertItemsCountInOrderSummary
		$I->see("10 of 11 Items in Cart", "div.items-in-cart div.title"); // stepKey: seeOrderSummaryTextAssertItemsCountInOrderSummary
		$I->waitForPageLoad(30); // stepKey: seeOrderSummaryTextAssertItemsCountInOrderSummaryWaitForPageLoad
		$I->seeElement(".title[role='tab']"); // stepKey: clickOnOrderSummaryTabAssertItemsCountInOrderSummary
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1AssertItemsCountInOrderSummary
		$I->comment("Exiting Action Group [AssertItemsCountInOrderSummary] StorefrontCheckoutAndAssertOrderSummaryDisplayActionGroup");
		$I->comment("Entering Action Group [seeViewAndEditLinkInOrderSummary] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSeeViewAndEditLinkInOrderSummary
		$I->scrollTo(".action.viewcart"); // stepKey: scrollToElementSeeViewAndEditLinkInOrderSummary
		$I->waitForPageLoad(30); // stepKey: scrollToElementSeeViewAndEditLinkInOrderSummaryWaitForPageLoad
		$I->seeElement(".action.viewcart"); // stepKey: assertElementSeeViewAndEditLinkInOrderSummary
		$I->waitForPageLoad(30); // stepKey: assertElementSeeViewAndEditLinkInOrderSummaryWaitForPageLoad
		$I->comment("Exiting Action Group [seeViewAndEditLinkInOrderSummary] AssertStorefrontSeeElementActionGroup");
		$I->comment("Click and open order summary tab");
		$I->conditionalClick(".title[role='tab']", ".title[aria-expanded='false']", true); // stepKey: clickOnOrderSummaryTab
		$I->waitForPageLoad(30); // stepKey: clickOnOrderSummaryTabWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Assert Shipping Page");
		$I->comment("Entering Action Group [assertShippingPageDisplay] StorefrontAssertShippingAddressPageDisplayActionGroup");
		$I->seeInCurrentUrl("checkout/#shipping"); // stepKey: seeCurrentUrlAssertShippingPageDisplay
		$I->seeElement("//li[contains(@class,'opc-progress-bar-item')]//*[text()='Shipping']"); // stepKey: seeShippingTabAssertShippingPageDisplay
		$I->waitForPageLoad(30); // stepKey: seeShippingTabAssertShippingPageDisplayWaitForPageLoad
		$I->seeElement("#checkout-step-shipping"); // stepKey: seeShippingBlockAssertShippingPageDisplay
		$I->comment("Exiting Action Group [assertShippingPageDisplay] StorefrontAssertShippingAddressPageDisplayActionGroup");
		$I->comment("Assert Product2 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct2InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct2', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct2InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct2InOrderSummary
		$I->see("$20.00", ".price"); // stepKey: seeProductPriceAssertProduct2InOrderSummary
		$I->comment("Exiting Action Group [assertProduct2InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product3 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct3InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct3', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct3InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct3InOrderSummary
		$I->see("$30.00", ".price"); // stepKey: seeProductPriceAssertProduct3InOrderSummary
		$I->comment("Exiting Action Group [assertProduct3InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product4 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct4InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct4', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct4InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct4InOrderSummary
		$I->see("$40.00", ".price"); // stepKey: seeProductPriceAssertProduct4InOrderSummary
		$I->comment("Exiting Action Group [assertProduct4InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product5 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct5InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct5', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct5InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct5InOrderSummary
		$I->see("$50.00", ".price"); // stepKey: seeProductPriceAssertProduct5InOrderSummary
		$I->comment("Exiting Action Group [assertProduct5InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product6 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct6InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct6', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct6InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct6InOrderSummary
		$I->see("$60.00", ".price"); // stepKey: seeProductPriceAssertProduct6InOrderSummary
		$I->comment("Exiting Action Group [assertProduct6InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product7 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct7InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct7', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct7InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct7InOrderSummary
		$I->see("$70.00", ".price"); // stepKey: seeProductPriceAssertProduct7InOrderSummary
		$I->comment("Exiting Action Group [assertProduct7InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product8 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct8InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct8', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct8InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct8InOrderSummary
		$I->see("$80.00", ".price"); // stepKey: seeProductPriceAssertProduct8InOrderSummary
		$I->comment("Exiting Action Group [assertProduct8InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product9 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct9InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct9', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct9InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct9InOrderSummary
		$I->see("$90.00", ".price"); // stepKey: seeProductPriceAssertProduct9InOrderSummary
		$I->comment("Exiting Action Group [assertProduct9InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product10 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct10InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct10', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct10InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct10InOrderSummary
		$I->see("$100.00", ".price"); // stepKey: seeProductPriceAssertProduct10InOrderSummary
		$I->comment("Exiting Action Group [assertProduct10InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product11 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct11InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('simpleProduct11', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct11InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct11InOrderSummary
		$I->see("$110.00", ".price"); // stepKey: seeProductPriceAssertProduct11InOrderSummary
		$I->comment("Exiting Action Group [assertProduct11InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
	}
}
