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
 * @Title("MC-3078: Admin can create product attribute with text swatch")
 * @Description("Admin can create product attribute with text swatch<h3>Test files</h3>app/code/Magento/Swatches/Test/Mftf/Test/AdminCreateTextSwatchTest.xml<br>")
 * @TestCaseId("MC-3078")
 * @group Swatches
 */
class AdminCreateTextSwatchTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Features({"Swatches"})
	 * @Stories({"Create/configure swatches"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateTextSwatchTest(AcceptanceTester $I)
	{
		$I->comment("Create a new product attribute of type \"Text Swatch\"");
		$I->comment("Entering Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product_attribute/new/"); // stepKey: goToNewProductAttributePageGoToNewProductAttributePage
		$I->waitForPageLoad(30); // stepKey: waitForAttributePageLoadGoToNewProductAttributePage
		$I->comment("Exiting Action Group [goToNewProductAttributePage] AdminNavigateToNewProductAttributePageActionGroup");
		$I->fillField("#attribute_label", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillDefaultLabel
		$I->selectOption("#frontend_input", "swatch_text"); // stepKey: selectInputType
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch0
		$I->fillField("input[name='swatchtext[value][option_0][0]']", "red"); // stepKey: fillSwatch0
		$I->fillField("input[name='optiontext[value][option_0][0]']", "Something red."); // stepKey: fillDescription0
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch1
		$I->fillField("input[name='swatchtext[value][option_1][0]']", "green"); // stepKey: fillSwatch1
		$I->fillField("input[name='optiontext[value][option_1][0]']", "Something green."); // stepKey: fillDescription1
		$I->click("#add_new_swatch_text_option_button"); // stepKey: clickAddSwatch2
		$I->fillField("input[name='swatchtext[value][option_2][0]']", "blue"); // stepKey: fillSwatch2
		$I->fillField("input[name='optiontext[value][option_2][0]']", "Something blue."); // stepKey: fillDescription2
		$I->click("#advanced_fieldset-wrapper"); // stepKey: expandAdvancedProperties
		$I->selectOption("#is_global", "1"); // stepKey: selectGlobalScope
		$I->comment("Save and verify");
		$I->click("#save_and_edit_button"); // stepKey: clickSave
		$I->waitForPageLoad(30); // stepKey: clickSaveWaitForPageLoad
		$I->seeInField("#attribute_label", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: seeDefaultLabel
		$I->seeInField("#swatch-text-options-panel table tbody tr:nth-of-type(1) td:nth-of-type(3) input", "red"); // stepKey: seeSwatch0
		$I->seeInField("#swatch-text-options-panel table tbody tr:nth-of-type(1) td:nth-of-type(4) input", "Something red."); // stepKey: seeDescription0
		$I->seeInField("#swatch-text-options-panel table tbody tr:nth-of-type(2) td:nth-of-type(3) input", "green"); // stepKey: seeSwatch1
		$I->seeInField("#swatch-text-options-panel table tbody tr:nth-of-type(2) td:nth-of-type(4) input", "Something green."); // stepKey: seeDescription1
		$I->seeInField("#swatch-text-options-panel table tbody tr:nth-of-type(3) td:nth-of-type(3) input", "blue"); // stepKey: seeSwatch2
		$I->seeInField("#swatch-text-options-panel table tbody tr:nth-of-type(3) td:nth-of-type(4) input", "Something blue."); // stepKey: seeDescription2
		$I->comment("Create a configurable product to verify the storefront with");
		$I->comment("Entering Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageAmOnProductGridPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadAmOnProductGridPage
		$I->comment("Exiting Action Group [amOnProductGridPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateConfigurableProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-configurable']", 30); // stepKey: waitForAddProductDropdownGoToCreateConfigurableProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-configurable']"); // stepKey: clickAddProductTypeGoToCreateConfigurableProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateConfigurableProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/configurable/"); // stepKey: seeNewProductUrlGoToCreateConfigurableProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateConfigurableProduct
		$I->comment("Exiting Action Group [goToCreateConfigurableProduct] GoToCreateProductPageActionGroup");
		$I->click("div[data-index='search-engine-optimization']"); // stepKey: openSeoSection
		$I->waitForPageLoad(30); // stepKey: openSeoSectionWaitForPageLoad
		$I->fillField("input[name='product[url_key]']", "testproductname" . msq("_defaultProduct")); // stepKey: fillUrlKey
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillProductForm
		$I->fillField(".admin__field[data-index=name] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "configurable" . msq("BaseConfigurableProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "123.00"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has weight"); // stepKey: selectWeightFillProductForm
		$I->fillField(".admin__field[data-index=weight] input", "2"); // stepKey: fillProductWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormActionGroup");
		$I->comment("Create configurations based off the Text Swatch we created earlier");
		$I->click("button[data-index='create_configurable_products_button']"); // stepKey: clickCreateConfigurations
		$I->waitForPageLoad(30); // stepKey: clickCreateConfigurationsWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: clickFilters
		$I->fillField(".admin__control-text[name='attribute_code']", "attribute" . msq("ProductAttributeFrontendLabel")); // stepKey: fillFilterAttributeCodeField
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButton
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonWaitForPageLoad
		$I->click("tr[data-repeat-index='0'] .admin__control-checkbox"); // stepKey: clickOnFirstCheckbox
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton1
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton1WaitForPageLoad
		$I->click(".action-select-all"); // stepKey: clickOnSelectAll
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton2
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton2WaitForPageLoad
		$I->click(".admin__field-label[for='apply-single-inventory-radio']"); // stepKey: clickOnApplySingleQuantityToEachSku
		$I->waitForPageLoad(30); // stepKey: clickOnApplySingleQuantityToEachSkuWaitForPageLoad
		$I->fillField("#apply-single-inventory-input", "1"); // stepKey: enterAttributeQuantity
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton3
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton3WaitForPageLoad
		$I->click(".steps-wizard-navigation .action-next-step"); // stepKey: clickOnNextButton4
		$I->waitForPageLoad(30); // stepKey: clickOnNextButton4WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickOnSaveButton2
		$I->waitForPageLoad(30); // stepKey: clickOnSaveButton2WaitForPageLoad
		$I->click("button[data-index='confirm_button']"); // stepKey: clickOnConfirmInPopup
		$I->waitForPageLoad(30); // stepKey: clickOnConfirmInPopupWaitForPageLoad
		$I->comment("Go to the product page and see text swatch options");
		$I->amOnPage("testproductname" . msq("_defaultProduct") . ".html"); // stepKey: amOnProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->see("red", "div.swatch-attribute-options"); // stepKey: seeRed
		$grabRedLabel = $I->grabAttributeFrom("div.swatch-option.text:nth-of-type(1)", "data-option-label"); // stepKey: grabRedLabel
		$I->assertEquals("Something red.", $grabRedLabel); // stepKey: assertRedLabel
		$I->see("green", "div.swatch-attribute-options"); // stepKey: seeGreen
		$grabGreenLabel = $I->grabAttributeFrom("div.swatch-option.text:nth-of-type(2)", "data-option-label"); // stepKey: grabGreenLabel
		$I->assertEquals("Something green.", $grabGreenLabel); // stepKey: assertGreenLabel
		$I->see("blue", "div.swatch-attribute-options"); // stepKey: seeBlue
		$grabBlueLabel = $I->grabAttributeFrom("div.swatch-option.text:nth-of-type(3)", "data-option-label"); // stepKey: grabBlueLabel
		$I->assertEquals("Something blue.", $grabBlueLabel); // stepKey: assertBlueLabel
	}
}
