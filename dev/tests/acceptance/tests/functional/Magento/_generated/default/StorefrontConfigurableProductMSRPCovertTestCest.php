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
 * @Title("MC-37575: Verify convert MSRP currency of configurable product options")
 * @Description("Check convert MSRP currency of configurable product options.<h3>Test files</h3>app/code/Magento/ConfigurableProduct/Test/Mftf/Test/StorefrontConfigurableProductViewTest/StorefrontConfigurableProductMSRPCovertTest.xml<br>")
 * @TestCaseId("MC-37575")
 * @group ConfigurableProduct
 */
class StorefrontConfigurableProductMSRPCovertTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createConfigProduct", "hook", "ApiConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleProductWithPrice50", ["createConfigProductAttribute", "getConfigAttributeOption1"], []); // stepKey: createConfigChildProduct1
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleProductWithPrice60", ["createConfigProductAttribute", "getConfigAttributeOption2"], []); // stepKey: createConfigChildProduct2
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->createEntity("enableMAP", "hook", "MsrpEnableMAP", [], []); // stepKey: enableMAP
		$setCurrencyAllow = $I->magentoCLI("config:set currency/options/allow EUR,USD", 60); // stepKey: setCurrencyAllow
		$I->comment($setCurrencyAllow);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteConfigProduct
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteConfigChildProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteConfigChildProduct2
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->createEntity("disableMAP", "hook", "MsrpDisableMAP", [], []); // stepKey: disableMAP
		$setCurrencyAllow = $I->magentoCLI("config:set currency/options/allow USD", 60); // stepKey: setCurrencyAllow
		$I->comment($setCurrencyAllow);
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"ConfigurableProduct"})
	 * @Stories({"View configurable product options, verify convert MSRP currency on storefront."})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontConfigurableProductMSRPCovertTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToFirstChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct1', 'id', 'test')); // stepKey: goToProductGoToFirstChildProductEditPage
		$I->comment("Exiting Action Group [goToFirstChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad
		$I->comment("Entering Action Group [setAdvancedPricingFirst] AdminSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonSetAdvancedPricingFirst
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonSetAdvancedPricingFirstWaitForPageLoad
		$I->waitForElement("//input[@name='product[msrp]']", 30); // stepKey: waitForMsrpSetAdvancedPricingFirst
		$I->waitForPageLoad(30); // stepKey: waitForMsrpSetAdvancedPricingFirstWaitForPageLoad
		$I->fillField("//input[@name='product[msrp]']", "100"); // stepKey: setMsrpForFirstChildProductSetAdvancedPricingFirst
		$I->waitForPageLoad(30); // stepKey: setMsrpForFirstChildProductSetAdvancedPricingFirstWaitForPageLoad
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonSetAdvancedPricingFirst
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonSetAdvancedPricingFirstWaitForPageLoad
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSetAdvancedPricingFirst
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSetAdvancedPricingFirst
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSetAdvancedPricingFirstWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSetAdvancedPricingFirst
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSetAdvancedPricingFirstWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSetAdvancedPricingFirst
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSetAdvancedPricingFirst
		$I->comment("Exiting Action Group [setAdvancedPricingFirst] AdminSetAdvancedPricingActionGroup");
		$I->comment("Entering Action Group [goToSecondChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('createConfigChildProduct2', 'id', 'test')); // stepKey: goToProductGoToSecondChildProductEditPage
		$I->comment("Exiting Action Group [goToSecondChildProductEditPage] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad1
		$I->comment("Entering Action Group [setAdvancedPricingSecond] AdminSetAdvancedPricingActionGroup");
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickOnAdvancedPricingButtonSetAdvancedPricingSecond
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedPricingButtonSetAdvancedPricingSecondWaitForPageLoad
		$I->waitForElement("//input[@name='product[msrp]']", 30); // stepKey: waitForMsrpSetAdvancedPricingSecond
		$I->waitForPageLoad(30); // stepKey: waitForMsrpSetAdvancedPricingSecondWaitForPageLoad
		$I->fillField("//input[@name='product[msrp]']", "100"); // stepKey: setMsrpForFirstChildProductSetAdvancedPricingSecond
		$I->waitForPageLoad(30); // stepKey: setMsrpForFirstChildProductSetAdvancedPricingSecondWaitForPageLoad
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneButtonSetAdvancedPricingSecond
		$I->waitForPageLoad(30); // stepKey: clickDoneButtonSetAdvancedPricingSecondWaitForPageLoad
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSetAdvancedPricingSecond
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSetAdvancedPricingSecond
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSetAdvancedPricingSecondWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSetAdvancedPricingSecond
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSetAdvancedPricingSecondWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSetAdvancedPricingSecond
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSetAdvancedPricingSecond
		$I->comment("Exiting Action Group [setAdvancedPricingSecond] AdminSetAdvancedPricingActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Entering Action Group [navigateToProduct] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageNavigateToProduct
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadNavigateToProduct
		$I->comment("Exiting Action Group [navigateToProduct] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [switchEURCurrency] StorefrontSwitchCurrencyActionGroup");
		$I->click("#switcher-currency-trigger"); // stepKey: openToggleSwitchEURCurrency
		$I->waitForPageLoad(30); // stepKey: openToggleSwitchEURCurrencyWaitForPageLoad
		$I->waitForElementVisible("//div[@id='switcher-currency-trigger']/following-sibling::ul//a[contains(text(), 'EUR')]", 30); // stepKey: waitForCurrencySwitchEURCurrency
		$I->waitForPageLoad(10); // stepKey: waitForCurrencySwitchEURCurrencyWaitForPageLoad
		$I->click("//div[@id='switcher-currency-trigger']/following-sibling::ul//a[contains(text(), 'EUR')]"); // stepKey: chooseCurrencySwitchEURCurrency
		$I->waitForPageLoad(10); // stepKey: chooseCurrencySwitchEURCurrencyWaitForPageLoad
		$I->see("EUR", "#switcher-currency-trigger span"); // stepKey: seeSelectedCurrencySwitchEURCurrency
		$I->comment("Exiting Action Group [switchEURCurrency] StorefrontSwitchCurrencyActionGroup");
		$I->selectOption("#product-options-wrapper .super-attribute-select", $I->retrieveEntityField('getConfigAttributeOption1', 'value', 'test')); // stepKey: selectFirstOption
		$I->waitForElement("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]", 30); // stepKey: waitForLoad
		$grabProductMapPrice = $I->grabTextFrom("//div[@class='price-box price-final_price']//span[contains(@class, 'price-msrp_price')]"); // stepKey: grabProductMapPrice
		$I->assertNotEquals("€100.00", ($grabProductMapPrice)); // stepKey: assertProductMapPrice
	}
}
