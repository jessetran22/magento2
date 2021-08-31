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
 * @Title("MC-38883: Validate qty increments for decimal fraction quantity works")
 * @Description("Validate qty increments for decimal fraction quantity works<h3>Test files</h3>app/code/Magento/CatalogInventory/Test/Mftf/Test/StorefrontValidateQuantityIncrementsWithDecimalInventoryTest.xml<br>")
 * @TestCaseId("MC-38883")
 * @group catalogInventory
 */
class StorefrontValidateQuantityIncrementsWithDecimalInventoryTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createPreReqCategory", "hook", "_defaultCategory", [], []); // stepKey: createPreReqCategory
		$I->createEntity("createPreReqSimpleProduct", "hook", "SimpleProduct", ["createPreReqCategory"], []); // stepKey: createPreReqSimpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Clear Filters");
		$I->comment("Entering Action Group [ClearFiltersAfter] AdminClearFiltersActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/"); // stepKey: GoToCatalogProductPageClearFiltersAfter
		$I->waitForPageLoad(30); // stepKey: WaitForPageToLoadClearFiltersAfter
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", "//div[@class='admin__data-grid-header']//button[@data-action='grid-filter-reset']", true); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersAfter
		$I->waitForPageLoad(30); // stepKey: ClickOnButtonToRemoveFiltersIfPresentClearFiltersAfterWaitForPageLoad
		$I->comment("Exiting Action Group [ClearFiltersAfter] AdminClearFiltersActionGroup");
		$I->deleteEntity("createPreReqCategory", "hook"); // stepKey: deletePreReqCategory
		$I->deleteEntity("createPreReqSimpleProduct", "hook"); // stepKey: deletePreReqSimpleProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Features({"CatalogInventory"})
	 * @Stories({"Qty increments wrong calculation for decimal fraction quantity"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontValidateQuantityIncrementsWithDecimalInventoryTest(AcceptanceTester $I)
	{
		$I->comment("Step1. Login as admin. Go to Catalog > Products page. Filtering *prod1*. Open *prod1* to edit");
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [filterGroupedProductOptions] SearchForProductOnBackendActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: navigateToProductIndexFilterGroupedProductOptions
		$I->waitForPageLoad(60); // stepKey: waitForProductsPageToLoadFilterGroupedProductOptions
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersSectionOnProductsPageFilterGroupedProductOptions
		$I->conditionalClick("//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", "//div[@class='admin__data-grid-header']//button[@class='action-tertiary action-clear']", true); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptions
		$I->waitForPageLoad(10); // stepKey: cleanFiltersIfTheySetFilterGroupedProductOptionsWaitForPageLoad
		$I->fillField("input[name=sku]", "SimpleProduct" . msq("SimpleProduct")); // stepKey: fillSkuFieldOnFiltersSectionFilterGroupedProductOptions
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptions
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFilterGroupedProductOptionsWaitForPageLoad
		$I->comment("Exiting Action Group [filterGroupedProductOptions] SearchForProductOnBackendActionGroup");
		$I->comment("Step2. Update product Advanced Inventory Setting.
        Set *Qty Uses Decimals* to *Yes* and *Enable Qty Increments* to *Yes* and *Qty Increments* to *3.33*.");
		$I->comment("Entering Action Group [openProduct] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->click("table.data-grid tr.data-row:nth-child(1) td:nth-child(2)"); // stepKey: openProductForEditOpenProduct
		$I->waitForPageLoad(30); // stepKey: openProductForEditOpenProductWaitForPageLoad
		$I->comment("Exiting Action Group [openProduct] OpenProductForEditByClickingRowXColumnYInProductGridActionGroup");
		$I->comment("Entering Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->click("button[data-index='advanced_inventory_button'].action-additional"); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: clickOnAdvancedInventoryLinkClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdvancedInventoryPageToLoadClickOnAdvancedInventoryLink
		$I->comment("Wait for close button appeared. That means animation finished and modal window is fully visible");
		$I->waitForElementVisible(".product_form_product_form_advanced_inventory_modal button.action-close", 30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLink
		$I->waitForPageLoad(30); // stepKey: waitForCloseButtonAppearedClickOnAdvancedInventoryLinkWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnAdvancedInventoryLink] AdminClickOnAdvancedInventoryLinkActionGroup");
		$I->comment("Entering Action Group [setQtyUsesDecimalsConfig] AdminSetQtyUsesDecimalsConfigActionGroup");
		$I->selectOption("//*[@name='product[stock_data][is_qty_decimal]']", "Yes"); // stepKey: setQtyUsesDecimalsConfigSetQtyUsesDecimalsConfig
		$I->comment("Exiting Action Group [setQtyUsesDecimalsConfig] AdminSetQtyUsesDecimalsConfigActionGroup");
		$I->comment("Entering Action Group [setEnableQtyIncrements] AdminSetEnableQtyIncrementsActionGroup");
		$I->scrollTo("//*[@name='product[stock_data][enable_qty_increments]']"); // stepKey: scrollToEnableQtyIncrementsSetEnableQtyIncrements
		$I->click("//input[@name='product[stock_data][use_config_enable_qty_inc]']"); // stepKey: clickOnEnableQtyIncrementsUseConfigSettingsCheckboxSetEnableQtyIncrements
		$I->selectOption("//*[@name='product[stock_data][enable_qty_increments]']", "Yes"); // stepKey: setEnableQtyIncrementsSetEnableQtyIncrements
		$I->comment("Exiting Action Group [setEnableQtyIncrements] AdminSetEnableQtyIncrementsActionGroup");
		$I->comment("Entering Action Group [setQtyIncrementsValue] AdminSetQtyIncrementsForProductActionGroup");
		$I->scrollTo("//input[@name='product[stock_data][use_config_qty_increments]']"); // stepKey: scrollToQtyIncrementsUseConfigSettingsSetQtyIncrementsValue
		$I->click("//input[@name='product[stock_data][use_config_qty_increments]']"); // stepKey: clickOnQtyIncrementsUseConfigSettingsSetQtyIncrementsValue
		$I->scrollTo("//input[@name='product[stock_data][qty_increments]']"); // stepKey: scrollToQtyIncrementsSetQtyIncrementsValue
		$I->fillField("//input[@name='product[stock_data][qty_increments]']", "3.33"); // stepKey: fillQtyIncrementsSetQtyIncrementsValue
		$I->comment("Exiting Action Group [setQtyIncrementsValue] AdminSetQtyIncrementsForProductActionGroup");
		$I->comment("Entering Action Group [clickOnDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->click("//aside[contains(@class,'product_form_product_form_advanced_inventory_modal')]//button[contains(@data-role,'action')]"); // stepKey: clickOnDoneButtonClickOnDoneButton
		$I->waitForPageLoad(5); // stepKey: clickOnDoneButtonClickOnDoneButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductPageToLoadClickOnDoneButton
		$I->comment("Exiting Action Group [clickOnDoneButton] AdminSubmitAdvancedInventoryFormActionGroup");
		$I->comment("Step3. Save the product");
		$I->comment("Entering Action Group [clickOnSaveButton2] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickOnSaveButton2
		$I->waitForPageLoad(30); // stepKey: saveProductClickOnSaveButton2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickOnSaveButton2
		$I->comment("Exiting Action Group [clickOnSaveButton2] AdminProductFormSaveActionGroup");
		$I->comment("Step4. Open *Customer view* (Go to *Store Front*). Open *prod1* page (Find via search and click on product name)");
		$I->amOnPage("/" . $I->retrieveEntityField('createPreReqSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPage
		$I->comment("Step5. Fill *23.31* in *Qty*. Click on button *Add to Cart*");
		$I->fillField("input.input-text.qty", "23.31"); // stepKey: fillQty
		$I->waitForPageLoad(30); // stepKey: fillQtyWaitForPageLoad
		$I->click("button.action.tocart.primary"); // stepKey: clickOnAddToCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToCartWaitForPageLoad
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded
		$I->waitForPageLoad(30); // stepKey: waitForProductAddedWaitForPageLoad
		$I->comment("Step6. Verify the product is successfully added to the cart with success message");
		$I->see("You added " . $I->retrieveEntityField('createPreReqSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartMessage
	}
}
