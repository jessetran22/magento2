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
 * @Title("MC-39480: Checking Fixed Amount Cart Price Rule is correctly applied to bundle products")
 * @Description("Checking Fixed Amount Cart Price Rule is correctly applied to bundle products<h3>Test files</h3>app/code/Magento/SalesRule/Test/Mftf/Test/StorefrontAssertFixedCartDiscountAmountForBundleProductTest.xml<br>")
 * @group SalesRule
 * @TestCaseId("MC-39480")
 */
class StorefrontAssertFixedCartDiscountAmountForBundleProductTestCest
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
		$I->createEntity("createSalesRule", "hook", "SalesRuleNoCouponWithFixedDiscountWholeCart", [], []); // stepKey: createSalesRule
		$I->comment("Entering Action Group [createBundleProduct] AdminCreateApiDynamicBundleProductAllOptionTypesActionGroup");
		$I->comment("Create simple products");
		$simpleProduct1CreateBundleProductFields['price'] = "10";
		$I->createEntity("simpleProduct1CreateBundleProduct", "hook", "SimpleProduct2", [], $simpleProduct1CreateBundleProductFields); // stepKey: simpleProduct1CreateBundleProduct
		$simpleProduct2CreateBundleProductFields['price'] = "20";
		$I->createEntity("simpleProduct2CreateBundleProduct", "hook", "SimpleProduct2", [], $simpleProduct2CreateBundleProductFields); // stepKey: simpleProduct2CreateBundleProduct
		$I->comment("Create Bundle product");
		$createBundleProductCreateBundleProductFields['name'] = "Api Dynamic Bundle Product";
		$I->createEntity("createBundleProductCreateBundleProduct", "hook", "ApiBundleProduct", [], $createBundleProductCreateBundleProductFields); // stepKey: createBundleProductCreateBundleProduct
		$createDropDownBundleOptionCreateBundleProductFields['title'] = "Drop-down Option";
		$I->createEntity("createDropDownBundleOptionCreateBundleProduct", "hook", "DropDownBundleOption", ["createBundleProductCreateBundleProduct"], $createDropDownBundleOptionCreateBundleProductFields); // stepKey: createDropDownBundleOptionCreateBundleProduct
		$createBundleRadioButtonsOptionCreateBundleProductFields['title'] = "Radio Buttons Option";
		$I->createEntity("createBundleRadioButtonsOptionCreateBundleProduct", "hook", "RadioButtonsOption", ["createBundleProductCreateBundleProduct"], $createBundleRadioButtonsOptionCreateBundleProductFields); // stepKey: createBundleRadioButtonsOptionCreateBundleProduct
		$createBundleCheckboxOptionCreateBundleProductFields['title'] = "Checkbox Option";
		$I->createEntity("createBundleCheckboxOptionCreateBundleProduct", "hook", "CheckboxOption", ["createBundleProductCreateBundleProduct"], $createBundleCheckboxOptionCreateBundleProductFields); // stepKey: createBundleCheckboxOptionCreateBundleProduct
		$I->createEntity("linkCheckboxOptionToProduct1CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createBundleCheckboxOptionCreateBundleProduct", "simpleProduct1CreateBundleProduct"], []); // stepKey: linkCheckboxOptionToProduct1CreateBundleProduct
		$I->createEntity("linkCheckboxOptionToProduct2CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createBundleCheckboxOptionCreateBundleProduct", "simpleProduct2CreateBundleProduct"], []); // stepKey: linkCheckboxOptionToProduct2CreateBundleProduct
		$I->createEntity("linkDropDownOptionToProduct1CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createDropDownBundleOptionCreateBundleProduct", "simpleProduct1CreateBundleProduct"], []); // stepKey: linkDropDownOptionToProduct1CreateBundleProduct
		$I->createEntity("linkDropDownOptionToProduct2CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createDropDownBundleOptionCreateBundleProduct", "simpleProduct2CreateBundleProduct"], []); // stepKey: linkDropDownOptionToProduct2CreateBundleProduct
		$I->createEntity("linkRadioButtonsOptionToProduct1CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createBundleRadioButtonsOptionCreateBundleProduct", "simpleProduct1CreateBundleProduct"], []); // stepKey: linkRadioButtonsOptionToProduct1CreateBundleProduct
		$I->createEntity("linkRadioButtonsOptionToProduct2CreateBundleProduct", "hook", "ApiBundleLink", ["createBundleProductCreateBundleProduct", "createBundleRadioButtonsOptionCreateBundleProduct", "simpleProduct2CreateBundleProduct"], []); // stepKey: linkRadioButtonsOptionToProduct2CreateBundleProduct
		$runCronIndexCreateBundleProduct = $I->magentoCron("index", 90); // stepKey: runCronIndexCreateBundleProduct
		$I->comment($runCronIndexCreateBundleProduct);
		$I->comment("Exiting Action Group [createBundleProduct] AdminCreateApiDynamicBundleProductAllOptionTypesActionGroup");
		$I->comment("Entering Action Group [reindexCatalogInventory] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindexCatalogInventory = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock"); // stepKey: reindexSpecifiedIndexersReindexCatalogInventory
		$I->comment($reindexSpecifiedIndexersReindexCatalogInventory);
		$I->comment("Exiting Action Group [reindexCatalogInventory] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSalesRule", "hook"); // stepKey: deleteSalesRule
		$I->deleteEntity("createBundleProductCreateBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("simpleProduct1CreateBundleProduct", "hook"); // stepKey: deleteSimpleProduct1
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
	 * @Features({"SalesRule"})
	 * @Stories({"Fixed Amount Cart Price Rule"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAssertFixedCartDiscountAmountForBundleProductTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProductCreateBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->click("#bundle-slide"); // stepKey: clickCustomize
		$I->waitForPageLoad(30); // stepKey: clickCustomizeWaitForPageLoad
		$I->selectOption("//label//span[contains(text(), 'Drop-down Option')]/../..//div[@class='control']//select", $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'name', 'test') . " +$" . $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'price', 'test') . ".00"); // stepKey: selectOption0Product1
		$I->seeOptionIsSelected("//label//span[contains(text(), 'Drop-down Option')]/../..//div[@class='control']//select", $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'name', 'test') . " +$" . $I->retrieveEntityField('simpleProduct2CreateBundleProduct', 'price', 'test') . ".00"); // stepKey: checkOption0Product1
		$I->checkOption("//label//span[contains(text(), 'Radio Buttons Option')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: selectOption1Product0
		$I->seeCheckboxIsChecked("//label//span[contains(text(), 'Radio Buttons Option')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: checkOption1Product0
		$I->checkOption("//label//span[contains(text(), 'Checkbox Option')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: selectOption2Product0
		$I->seeCheckboxIsChecked("//label//span[contains(text(), 'Checkbox Option')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: checkOption2Product0
		$I->checkOption("//label//span[contains(text(), 'Checkbox Option')]/../..//div[@class='control']//div[@class='field choice'][2]/input"); // stepKey: selectOption2Product1
		$I->seeCheckboxIsChecked("//label//span[contains(text(), 'Checkbox Option')]/../..//div[@class='control']//div[@class='field choice'][1]/input"); // stepKey: checkOption2Product1
		$I->comment("Entering Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldEnterProductQuantityAndAddToTheCart
		$I->fillField("#qty", "1"); // stepKey: fillTheProductQuantityEnterProductQuantityAndAddToTheCart
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadEnterProductQuantityAndAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageEnterProductQuantityAndAddToTheCart
		$I->comment("Exiting Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->comment("Entering Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenShoppingCartPage
		$I->comment("Exiting Action Group [openShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [cartAssert] StorefrontCheckCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlCartAssert
		$I->waitForPageLoad(30); // stepKey: waitForCartPageCartAssert
		$I->conditionalClick("#block-shipping-heading", "#co-shipping-method-form", false); // stepKey: openEstimateShippingSectionCartAssert
		$I->waitForElementVisible("#s_method_flatrate_flatrate", 30); // stepKey: waitForShippingSectionCartAssert
		$I->waitForPageLoad(30); // stepKey: waitForShippingSectionCartAssertWaitForPageLoad
		$I->checkOption("#s_method_flatrate_flatrate"); // stepKey: selectShippingMethodCartAssert
		$I->waitForPageLoad(30); // stepKey: selectShippingMethodCartAssertWaitForPageLoad
		$I->scrollTo("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: scrollToSummaryCartAssert
		$I->see("60.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalCartAssert
		$I->see("(Flat Rate - Fixed)", "//*[@id='cart-totals']//tr[@class='totals shipping excl']//th//span[@class='value']"); // stepKey: assertShippingMethodCartAssert
		$I->waitForText("5.00", 45, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingCartAssert
		$I->see("15.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalCartAssert
		$I->comment("Exiting Action Group [cartAssert] StorefrontCheckCartActionGroup");
	}
}
