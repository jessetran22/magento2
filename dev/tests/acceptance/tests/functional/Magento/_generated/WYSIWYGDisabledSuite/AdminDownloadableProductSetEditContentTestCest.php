<?php
namespace Magento\AcceptanceTest\_WYSIWYGDisabledSuite\Backend;

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
 * @Title("MC-3426: Admin should be able to set/edit product Content when editing a downloadable product")
 * @Description("Admin should be able to set/edit product Content when editing a downloadable product<h3>Test files</h3>app/code/Magento/Downloadable/Test/Mftf/Test/AdminDownloadableProductSetEditContentTest.xml<br>")
 * @TestCaseId("MC-3426")
 * @group Downloadable
 * @group WYSIWYGDisabled
 */
class AdminDownloadableProductSetEditContentTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete simple product");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteProduct
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteProduct
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteProductWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteProduct
		$I->fillField("input.admin__control-text[name='sku']", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFilterDeleteProduct
		$I->fillField("input.admin__control-text[name='name']", "DownloadableProduct" . msq("DownloadableProduct")); // stepKey: fillProductNameFilterDeleteProduct
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteProductWaitForPageLoad
		$I->see("downloadableproduct" . msq("DownloadableProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteProduct
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteProduct
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteProduct
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteProductWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteProduct
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteProductWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteProduct
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteProduct
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteProductWaitForPageLoad
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductUsingProductGridActionGroup");
		$I->comment("Admin Logout");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Delete downloadable product");
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
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Admin Login");
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Entering Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
		$disableWYSIWYGDisableWYSIWYG = $I->magentoCLI("config:set cms/wysiwyg/enabled disabled", 60); // stepKey: disableWYSIWYGDisableWYSIWYG
		$I->comment($disableWYSIWYGDisableWYSIWYG);
		$I->comment("Exiting Action Group [disableWYSIWYG] DisabledWYSIWYGActionGroup");
	}

	/**
	 * @Features({"Downloadable"})
	 * @Stories({"Create/edit downloadable product"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDownloadableProductSetEditContentTest(AcceptanceTester $I)
	{
		$I->comment("Create product");
		$I->comment("Entering Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageNavigateToProductIndex
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadNavigateToProductIndex
		$I->comment("Exiting Action Group [navigateToProductIndex] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-downloadable']", 30); // stepKey: waitForAddProductDropdownGoToCreateProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-downloadable']"); // stepKey: clickAddProductTypeGoToCreateProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/downloadable/"); // stepKey: seeNewProductUrlGoToCreateProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateProduct
		$I->comment("Exiting Action Group [goToCreateProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillProductForm] FillMainProductFormNoWeightActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "DownloadableProduct" . msq("DownloadableProduct")); // stepKey: fillProductNameFillProductForm
		$I->fillField(".admin__field[data-index=sku] input", "downloadableproduct" . msq("DownloadableProduct")); // stepKey: fillProductSkuFillProductForm
		$I->fillField(".admin__field[data-index=price] input", "50.99"); // stepKey: fillProductPriceFillProductForm
		$I->fillField(".admin__field[data-index=qty] input", "100"); // stepKey: fillProductQtyFillProductForm
		$I->selectOption("select[name='product[quantity_and_stock_status][is_in_stock]']", "1"); // stepKey: selectStockStatusFillProductForm
		$I->waitForPageLoad(30); // stepKey: selectStockStatusFillProductFormWaitForPageLoad
		$I->selectOption("select[name='product[product_has_weight]']", "This item has no weight"); // stepKey: selectWeightFillProductForm
		$I->comment("Exiting Action Group [fillProductForm] FillMainProductFormNoWeightActionGroup");
		$I->comment("Add content");
		$I->comment("A generic scroll scrolls past this element, in doing this it fails to execute certain actions on the element and others below it. By scrolling slightly above it it resolves this issue.");
		$I->scrollTo("div[data-index='content']", 0, -100); // stepKey: scrollTo
		$I->waitForPageLoad(30); // stepKey: scrollToWaitForPageLoad
		$I->click("div[data-index='content']"); // stepKey: openDescriptionDropDown
		$I->waitForPageLoad(30); // stepKey: openDescriptionDropDownWaitForPageLoad
		$I->fillField("#product_form_description", "This is the long description"); // stepKey: fillLongDescription
		$I->fillField("#product_form_short_description", "This is the short description"); // stepKey: fillShortDescription
		$I->comment("save the product");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Edit content");
		$I->click("div[data-index='content']"); // stepKey: openDescriptionDropDownEdit
		$I->waitForPageLoad(30); // stepKey: openDescriptionDropDownEditWaitForPageLoad
		$I->scrollTo("div[data-index='content']"); // stepKey: scrollToEdit
		$I->waitForPageLoad(30); // stepKey: scrollToEditWaitForPageLoad
		$I->fillField("#product_form_description", "EDIT ~ This is the long description ~ EDIT"); // stepKey: editLongDescription
		$I->fillField("#product_form_short_description", "EDIT ~ This is the short description ~ EDIT"); // stepKey: editShortDescription
		$I->comment("save the product");
		$I->comment("Entering Action Group [clickSaveButtonAfterEdit] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButtonAfterEdit
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonAfterEditWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButtonAfterEdit
		$I->comment("Exiting Action Group [clickSaveButtonAfterEdit] AdminProductFormSaveActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShownAgain
		$I->comment("Checking content admin");
		$I->click("div[data-index='content']"); // stepKey: openDescriptionDropDownAgain
		$I->waitForPageLoad(30); // stepKey: openDescriptionDropDownAgainWaitForPageLoad
		$I->scrollTo("div[data-index='content']"); // stepKey: scrollToAgain
		$I->waitForPageLoad(30); // stepKey: scrollToAgainWaitForPageLoad
		$I->seeInField("#product_form_description", "EDIT ~ This is the long description ~ EDIT"); // stepKey: seeLongDescriptionAdmin
		$I->seeInField("#product_form_short_description", "EDIT ~ This is the short description ~ EDIT"); // stepKey: seeShortDescriptionAdmin
		$I->comment("Checking content storefront");
		$I->amOnPage("downloadableproduct" . msq("DownloadableProduct") . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->see("EDIT ~ This is the long description ~ EDIT", "#description .value"); // stepKey: seeLongDescriptionStorefront
		$I->see("EDIT ~ This is the short description ~ EDIT", "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: seeShortDescriptionStorefront
		$I->comment("Create product");
		$I->comment("Checking content storefront");
	}
}
