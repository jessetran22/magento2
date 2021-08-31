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
 * @Title("MC-14726: Create a simple products with all types of oprtions and add it to the cart")
 * @Description("Create a simple products with all types of oprtions and add it to the cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontAddProductWithAllTypesOfCustomOptionToTheShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14726")
 * @group mtf_migrated
 */
class StorefrontAddProductWithAllTypesOfCustomOptionToTheShoppingCartTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
		$I->updateEntity("createProduct", "hook", "productWithOptions",[]); // stepKey: updateProductWithCustomOptions
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddProductWithAllTypesOfCustomOptionToTheShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Open Product page in StoreFront");
		$I->comment("Entering Action Group [openProduct1PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct1PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct1PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('createProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct1PageAndVerifyProduct
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct1PageAndVerifyProduct
		$I->see($I->retrieveEntityField('createProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct1PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct1PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Fill Option Input field");
		$I->comment("Entering Action Group [fillTheOptionFieldInput] StorefrontFillOptionFieldInputActionGroup");
		$I->fillField("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionField')]/../div[@class='control']//input[@type='text']", "1"); // stepKey: fillOptionFieldFillTheOptionFieldInput
		$I->comment("Exiting Action Group [fillTheOptionFieldInput] StorefrontFillOptionFieldInputActionGroup");
		$I->comment("Fill Option Text Area");
		$I->comment("Entering Action Group [fillTheOptionTextAreaInput] StorefrontFillOptionTextAreaActionGroup");
		$I->fillField("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionArea')]/../div[@class='control']//textarea", "1"); // stepKey: fillOptionTextAreaFillTheOptionTextAreaInput
		$I->comment("Exiting Action Group [fillTheOptionTextAreaInput] StorefrontFillOptionTextAreaActionGroup");
		$I->comment("Attach file option");
		$I->comment("Entering Action Group [selectAndAttachFile] StorefrontAttachOptionFileActionGroup");
		$I->attachFile("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionFile')]/../div[@class='control']//input[@type='file']", "magento-logo.png"); // stepKey: attachFileSelectAndAttachFile
		$I->comment("Exiting Action Group [selectAndAttachFile] StorefrontAttachOptionFileActionGroup");
		$I->comment("Select Option From DropDown option");
		$I->comment("Entering Action Group [selectFirstOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionDropDown')]/../div[@class='control']//select", "OptionValueDropDown2"); // stepKey: fillDropDownAttributeOptionSelectFirstOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectFirstOption
		$I->comment("Exiting Action Group [selectFirstOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->scrollTo("//label[contains(., 'OptionMultiSelect')]"); // stepKey: scrollToMultiSelect
		$I->comment("Select CheckBox From CheckBox option");
		$I->comment("Entering Action Group [selectCheckBoxOption] StorefrontSelectOptionCheckBoxActionGroup");
		$I->checkOption("//div/input[@type='checkbox']/../label/span[contains(.,'OptionValueCheckbox')]"); // stepKey: SelectOptionRadioButtonSelectCheckBoxOption
		$I->comment("Exiting Action Group [selectCheckBoxOption] StorefrontSelectOptionCheckBoxActionGroup");
		$I->comment("Select RadioButton From Radio Button option");
		$I->comment("Entering Action Group [selectRadioButtonOption] StorefrontSelectOptionRadioButtonActionGroup");
		$I->checkOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionRadioButtons')]/../div[@class='control']//input[@price='99.99']"); // stepKey: SelectOptionCheckBoxSelectRadioButtonOption
		$I->comment("Exiting Action Group [selectRadioButtonOption] StorefrontSelectOptionRadioButtonActionGroup");
		$I->comment("Select option From MultiSelect option");
		$I->comment("Entering Action Group [selectOptionFromMultiSelect] StorefrontSelectOptionMultiSelectActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionMultiSelect')]/../div[@class='control']//select", "OptionValueMultiSelect2"); // stepKey: selectOptionSelectOptionFromMultiSelect
		$I->comment("Exiting Action Group [selectOptionFromMultiSelect] StorefrontSelectOptionMultiSelectActionGroup");
		$I->comment("Generate Date");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("Now"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$year = $date->format("Y");

		$I->comment("Select Month,Day and Year  From Date option");
		$I->comment("Entering Action Group [fillOptionDate] StorefrontSelectOptionDateActionGroup");
		$I->selectOption("//div[@class='field date required']//span[text()='OptionDate']/../..//div/select[@data-calendar-role='month']", "11"); // stepKey: selectMonthForOptionDateFillOptionDate
		$I->selectOption("//div[@class='field date required']//span[text()='OptionDate']/../..//div/select[@data-calendar-role='day']", "10"); // stepKey: selectDayForOptionDateFillOptionDate
		$I->selectOption("//div[@class='field date required']//span[text()='OptionDate']/../..//div/select[@data-calendar-role='year']", "$year"); // stepKey: selectYearForOptionDateFillOptionDate
		$I->comment("Exiting Action Group [fillOptionDate] StorefrontSelectOptionDateActionGroup");
		$I->comment("Select Month, Day, Year, Hour,Minute and DayPart from DateTime option");
		$I->comment("Entering Action Group [fillOptionDateAndTime] StorefrontSelectOptionDateTimeActionGroup");
		$I->selectOption("//div[@class='field date required']//span[text()='OptionDateTime']/../..//div/select[@data-calendar-role='month']", "11"); // stepKey: selectMonthForOptionDateFillOptionDateAndTime
		$I->selectOption("//div[@class='field date required']//span[text()='OptionDateTime']/../..//div/select[@data-calendar-role='day']", "10"); // stepKey: selectDayForOptionDateFillOptionDateAndTime
		$I->selectOption("//div[@class='field date required']//span[text()='OptionDateTime']/../..//div/select[@data-calendar-role='year']", "$year"); // stepKey: selectYearForOptionDateFillOptionDateAndTime
		$I->selectOption("//div[@class='field date required']//span[text()='OptionDateTime']/../..//div/select[@data-calendar-role='hour']", "10"); // stepKey: selectHourrForOptionDateTimeFillOptionDateAndTime
		$I->selectOption("//div[@class='field date required']//span[text()='OptionDateTime']/../..//div/select[@data-calendar-role='minute']", "20"); // stepKey: selectMinuteForOptionDateTimeFillOptionDateAndTime
		$I->selectOption("//div[@class='field date required']//span[text()='OptionDateTime']/../..//div/select[@data-calendar-role='day_part']", "AM"); // stepKey: selectDayPartForOptionDateTimeFillOptionDateAndTime
		$I->comment("Exiting Action Group [fillOptionDateAndTime] StorefrontSelectOptionDateTimeActionGroup");
		$I->comment("Select Hour,Minute and DayPart from Time option");
		$I->comment("Entering Action Group [fillOptionTime] StorefrontSelectOptionTimeActionGroup");
		$I->selectOption("//div[@class='field date required']//span[text()='OptionTime']/../..//div/select[@data-calendar-role='hour']", "10"); // stepKey: selectHourrForOptionDateTimeFillOptionTime
		$I->selectOption("//div[@class='field date required']//span[text()='OptionTime']/../..//div/select[@data-calendar-role='minute']", "20"); // stepKey: selectMinuteForOptionDateTimeFillOptionTime
		$I->selectOption("//div[@class='field date required']//span[text()='OptionTime']/../..//div/select[@data-calendar-role='day_part']", "AM"); // stepKey: selectDayPartForOptionDateTimeFillOptionTime
		$I->comment("Exiting Action Group [fillOptionTime] StorefrontSelectOptionTimeActionGroup");
		$I->comment("Add product to the cart");
		$I->fillField("#qty", "2"); // stepKey: fillQuantity
		$I->comment("Entering Action Group [addProductToTheCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToTheCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToTheCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToTheCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToTheCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToTheCart
		$I->waitForText("2", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToTheCart
		$I->comment("Exiting Action Group [addProductToTheCart] StorefrontAddProductToCartActionGroup");
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
		$I->see("2", "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: seeProductCountInCartAssertProductCountAndTextInMiniCart
		$I->see("2 Items in Cart", "//div[@class='items-total']"); // stepKey: seeNumberOfItemDisplayInMiniCartAssertProductCountAndTextInMiniCart
		$I->comment("Exiting Action Group [assertProductCountAndTextInMiniCart] StorefrontAssertMiniCartItemCountActionGroup");
		$I->comment("Assert Product Items in Mini cart");
		$I->comment("Entering Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$1,642.58", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct3MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='2']"); // stepKey: seeProductQuantity1AssertSimpleProduct3MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct3MiniCart
		$I->see("$3,285.16", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct3MiniCart
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct3MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
	}
}
