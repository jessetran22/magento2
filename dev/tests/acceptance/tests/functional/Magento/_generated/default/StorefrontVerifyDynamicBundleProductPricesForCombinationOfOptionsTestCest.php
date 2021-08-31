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
 * @Title("MAGETWO-43619: Verify dynamic bundle product prices for combination of options")
 * @Description("Verify prices for various configurations of Dynamic Bundle product<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/StorefrontVerifyDynamicBundleProductPricesForCombinationOfOptionsTest.xml<br>")
 * @TestCaseId("MAGETWO-43619")
 * @group bundle
 */
class StorefrontVerifyDynamicBundleProductPricesForCombinationOfOptionsTestCest
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
		$I->createEntity("createSubCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createSubCategory
		$I->comment("Create 5 simple product");
		$simpleProduct1Fields['price'] = "4.99";
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], $simpleProduct1Fields); // stepKey: simpleProduct1
		$simpleProduct2Fields['price'] = "2.89";
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], $simpleProduct2Fields); // stepKey: simpleProduct2
		$simpleProduct3Fields['price'] = "7.33";
		$I->createEntity("simpleProduct3", "hook", "SimpleProduct2", [], $simpleProduct3Fields); // stepKey: simpleProduct3
		$simpleProduct4Fields['price'] = "18.25";
		$I->createEntity("simpleProduct4", "hook", "SimpleProduct2", [], $simpleProduct4Fields); // stepKey: simpleProduct4
		$simpleProduct5Fields['price'] = "10.00";
		$I->createEntity("simpleProduct5", "hook", "SimpleProduct2", [], $simpleProduct5Fields); // stepKey: simpleProduct5
		$I->comment("Add special price to simple product");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openAdminEditPage] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleProduct5', 'id', 'hook')); // stepKey: goToProductOpenAdminEditPage
		$I->comment("Exiting Action Group [openAdminEditPage] AdminProductPageOpenByIdActionGroup");
		$I->comment("Entering Action Group [addSpecialPrice] AddSpecialPriceToProductActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSpecialPrice
		$I->click("button[data-index='advanced_pricing_button']"); // stepKey: clickAdvancedPricingLinkAddSpecialPrice
		$I->waitForPageLoad(30); // stepKey: clickAdvancedPricingLinkAddSpecialPriceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalAddSpecialPrice
		$I->waitForElementVisible("input[name='product[special_price]']", 30); // stepKey: waitSpecialPriceAddSpecialPrice
		$I->fillField("input[name='product[special_price]']", "8"); // stepKey: fillSpecialPriceAddSpecialPrice
		$I->click(".product_form_product_form_advanced_pricing_modal button.action-primary"); // stepKey: clickDoneAddSpecialPrice
		$I->waitForPageLoad(30); // stepKey: clickDoneAddSpecialPriceWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedPricingModalGoneAddSpecialPrice
		$I->waitForElementNotVisible("input[name='product[special_price]']", 30); // stepKey: waitForCloseModalWindowAddSpecialPrice
		$I->comment("Exiting Action Group [addSpecialPrice] AddSpecialPriceToProductActionGroup");
		$I->comment("Entering Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProductForm
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProductForm
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProductFormWaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProductForm
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProductFormWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProductForm
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProductForm
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProductForm
		$I->comment("Exiting Action Group [saveProductForm] SaveProductFormActionGroup");
		$I->comment("Create Bundle product");
		$I->createEntity("createBundleProduct", "hook", "ApiBundleProductPriceViewRange", ["createSubCategory"], []); // stepKey: createBundleProduct
		$createBundleOption1_1Fields['required'] = "false";
		$I->createEntity("createBundleOption1_1", "hook", "MultipleSelectOption", ["createBundleProduct"], $createBundleOption1_1Fields); // stepKey: createBundleOption1_1
		$I->createEntity("createBundleOption1_2", "hook", "CheckboxOption", ["createBundleProduct"], []); // stepKey: createBundleOption1_2
		$I->createEntity("linkOptionToProduct", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct1"], []); // stepKey: linkOptionToProduct
		$I->createEntity("linkOptionToProduct2", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct2"], []); // stepKey: linkOptionToProduct2
		$I->createEntity("linkOptionToProduct3", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_2", "simpleProduct3"], []); // stepKey: linkOptionToProduct3
		$I->createEntity("linkOptionToProduct4", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_2", "simpleProduct4"], []); // stepKey: linkOptionToProduct4
		$I->comment("Create Bundle product 2");
		$I->createEntity("createBundleProduct2", "hook", "ApiBundleProductPriceViewRange", ["createSubCategory"], []); // stepKey: createBundleProduct2
		$I->createEntity("createBundleOption2_1", "hook", "DropDownBundleOption", ["createBundleProduct2"], []); // stepKey: createBundleOption2_1
		$I->createEntity("createBundleOption2_2", "hook", "RadioButtonsOption", ["createBundleProduct2"], []); // stepKey: createBundleOption2_2
		$linkOptionToProduct5Fields['qty'] = "2";
		$I->createEntity("linkOptionToProduct5", "hook", "ApiBundleLink", ["createBundleProduct2", "createBundleOption2_1", "simpleProduct1"], $linkOptionToProduct5Fields); // stepKey: linkOptionToProduct5
		$I->createEntity("linkOptionToProduct6", "hook", "ApiBundleLink", ["createBundleProduct2", "createBundleOption2_1", "simpleProduct2"], []); // stepKey: linkOptionToProduct6
		$I->createEntity("linkOptionToProduct7", "hook", "ApiBundleLink", ["createBundleProduct2", "createBundleOption2_2", "simpleProduct3"], []); // stepKey: linkOptionToProduct7
		$linkOptionToProduct8Fields['qty'] = "5";
		$I->createEntity("linkOptionToProduct8", "hook", "ApiBundleLink", ["createBundleProduct2", "createBundleOption2_2", "simpleProduct4"], $linkOptionToProduct8Fields); // stepKey: linkOptionToProduct8
		$I->comment("Create Bundle product 3");
		$I->createEntity("createBundleProduct3", "hook", "ApiBundleProductPriceViewRange", ["createSubCategory"], []); // stepKey: createBundleProduct3
		$I->createEntity("createBundleOption3_1", "hook", "MultipleSelectOption", ["createBundleProduct3"], []); // stepKey: createBundleOption3_1
		$createBundleOption3_2Fields['required'] = "false";
		$I->createEntity("createBundleOption3_2", "hook", "DropDownBundleOption", ["createBundleProduct3"], $createBundleOption3_2Fields); // stepKey: createBundleOption3_2
		$I->createEntity("linkOptionToProduct9", "hook", "ApiBundleLink", ["createBundleProduct3", "createBundleOption3_1", "simpleProduct4"], []); // stepKey: linkOptionToProduct9
		$I->createEntity("linkOptionToProduct10", "hook", "ApiBundleLink", ["createBundleProduct3", "createBundleOption3_1", "simpleProduct5"], []); // stepKey: linkOptionToProduct10
		$I->createEntity("linkOptionToProduct11", "hook", "ApiBundleLink", ["createBundleProduct3", "createBundleOption3_2", "simpleProduct2"], []); // stepKey: linkOptionToProduct11
		$I->createEntity("linkOptionToProduct12", "hook", "ApiBundleLink", ["createBundleProduct3", "createBundleOption3_2", "simpleProduct3"], []); // stepKey: linkOptionToProduct12
		$I->comment("navigate to the tax configuration page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/tax/"); // stepKey: goToAdminTaxPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxConfigLoad
		$I->conditionalClick("#tax_calculation-head", "#tax_calculation-head.open", false); // stepKey: openCalculationSettingsTab
		$I->waitForPageLoad(30); // stepKey: openCalculationSettingsTabWaitForPageLoad
		$I->conditionalClick("#tax_calculation_algorithm_inherit", "#tax_calculation_algorithm[disabled='disabled']", true); // stepKey: clickCalculationMethodBasedCheckBox
		$I->selectOption("#tax_calculation_algorithm", "Total"); // stepKey: fillCalculationMethodBased
		$I->conditionalClick("#tax_calculation_based_on_inherit", "#tax_calculation_based_on[disabled='disabled']", true); // stepKey: clickTaxCalculationBasedCheckBox
		$I->selectOption("#tax_calculation_based_on", "Shipping Origin"); // stepKey: fillTaxCalculationBased
		$I->conditionalClick("#tax_calculation_price_includes_tax_inherit", "#tax_calculation_price_includes_tax[disabled='disabled']", true); // stepKey: clickCalculationPricesCheckBox
		$I->selectOption("#tax_calculation_price_includes_tax", "Excluding Tax"); // stepKey: clickCalculationPrices
		$I->conditionalClick("#tax_display-head", "#tax_display-head.open", false); // stepKey: openPriceDisplaySettings
		$I->waitForPageLoad(30); // stepKey: openPriceDisplaySettingsWaitForPageLoad
		$I->conditionalClick("#tax_display_type_inherit", "#tax_display_type[disabled='disabled']", true); // stepKey: clickDisplayProductPricesCheckBox
		$I->selectOption("#tax_display_type", "Excluding Tax"); // stepKey: clickDisplayProductPrices
		$I->comment("Save the settings");
		$I->scrollToTopOfPage(); // stepKey: scrollToTop
		$I->comment("Entering Action Group [saveTaxOptions] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveTaxOptions
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveTaxOptionsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveTaxOptions
		$I->comment("Exiting Action Group [saveTaxOptions] AdminSaveCategoryActionGroup");
		$I->see("You saved the configuration.", ".message-success"); // stepKey: seeSuccess
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock catalog_product_price"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("navigate to the tax configuration page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/tax/"); // stepKey: goToAdminTaxPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxConfigLoad
		$I->conditionalClick("#tax_calculation-head", "#tax_calculation-head.open", false); // stepKey: openCalculationSettingsTab
		$I->waitForPageLoad(30); // stepKey: openCalculationSettingsTabWaitForPageLoad
		$I->conditionalClick("#tax_calculation_algorithm_inherit", "#tax_calculation_algorithm[disabled='disabled']", true); // stepKey: clickCalculationMethodBasedCheckBox
		$I->selectOption("#tax_calculation_algorithm", "Total"); // stepKey: fillCalculationMethodBased
		$I->conditionalClick("#tax_calculation_based_on_inherit", "#tax_calculation_based_on[disabled='disabled']", true); // stepKey: clickTaxCalculationBasedCheckBox
		$I->selectOption("#tax_calculation_based_on", "Shipping Address"); // stepKey: fillTaxCalculationBased
		$I->conditionalClick("#tax_calculation_price_includes_tax_inherit", "#tax_calculation_price_includes_tax[disabled='disabled']", true); // stepKey: clickCalculationPricesCheckBox
		$I->selectOption("#tax_calculation_price_includes_tax", "Excluding Tax"); // stepKey: clickCalculationPrices
		$I->conditionalClick("#tax_display-head", "#tax_display-head.open", false); // stepKey: openPriceDisplaySettings
		$I->waitForPageLoad(30); // stepKey: openPriceDisplaySettingsWaitForPageLoad
		$I->conditionalClick("#tax_display_type_inherit", "#tax_display_type[disabled='disabled']", true); // stepKey: clickDisplayProductPricesCheckBox
		$I->selectOption("#tax_display_type", "Excluding Tax"); // stepKey: clickDisplayProductPrices
		$I->comment("Save the settings");
		$I->scrollToTopOfPage(); // stepKey: scrollToTop
		$I->comment("Entering Action Group [saveTaxOptions] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveTaxOptions
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveTaxOptionsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveTaxOptions
		$I->comment("Exiting Action Group [saveTaxOptions] AdminSaveCategoryActionGroup");
		$I->see("You saved the configuration.", ".message-success"); // stepKey: seeSuccess
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createSubCategory", "hook"); // stepKey: deleteSubCategory1
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("simpleProduct4", "hook"); // stepKey: deleteSimpleProduct4
		$I->deleteEntity("simpleProduct5", "hook"); // stepKey: deleteSimpleProduct5
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createBundleProduct2", "hook"); // stepKey: deleteBundleProduct2
		$I->deleteEntity("createBundleProduct3", "hook"); // stepKey: deleteBundleProduct3
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
	 * @Features({"Bundle"})
	 * @Stories({"View bundle products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontVerifyDynamicBundleProductPricesForCombinationOfOptionsTest(AcceptanceTester $I)
	{
		$I->comment("Go to storefront category page");
		$I->amOnPage("/" . $I->retrieveEntityField('createSubCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoad
		$I->see("From $7.33", "div[data-product-id='" . $I->retrieveEntityField('createBundleProduct', 'id', 'test') . "'] .price-from"); // stepKey: seePriceFromInCategoryBundle1
		$I->see("To $33.46", "div[data-product-id='" . $I->retrieveEntityField('createBundleProduct', 'id', 'test') . "'] .price-to"); // stepKey: seePriceToInCategoryBundle1
		$I->see("From $10.22", "div[data-product-id='" . $I->retrieveEntityField('createBundleProduct2', 'id', 'test') . "'] .price-from"); // stepKey: seePriceFromInCategoryBundle2
		$I->see("To $101.23", "div[data-product-id='" . $I->retrieveEntityField('createBundleProduct2', 'id', 'test') . "'] .price-to"); // stepKey: seePriceToInCategoryBundle2
		$I->see("From $8.00 Regular Price $10.00", "div[data-product-id='" . $I->retrieveEntityField('createBundleProduct3', 'id', 'test') . "'] .price-from"); // stepKey: seePriceFromInCategoryBundle3
		$I->see("To $33.58 Regular Price $35.58", "div[data-product-id='" . $I->retrieveEntityField('createBundleProduct3', 'id', 'test') . "'] .price-to"); // stepKey: seePriceToInCategoryBundle3
		$I->comment("Go to storefront product pages");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->see("From $7.33", ".product-info-price .price-from"); // stepKey: seePriceFromBundle1
		$I->see("To $33.46", ".product-info-price .price-to"); // stepKey: seePriceToBundle1
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onPageBundle2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->see("From $10.22", ".product-info-price .price-from"); // stepKey: seePriceFromBundle2
		$I->see("To $101.23", ".product-info-price .price-to"); // stepKey: seePriceToBundle2
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct3', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onPageBundle3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3
		$I->see("From $8.00 Regular Price $10.00", ".product-info-price .price-from"); // stepKey: seePriceFromBundle3
		$I->see("To $33.58 Regular Price $35.58", ".product-info-price .price-to"); // stepKey: seePriceToBundle3
	}
}
