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
 * @Title("MC-3342: Admin should be able to set/edit Related Products information when editing a bundle product")
 * @Description("Admin should be able to set/edit Related Products information when editing a bundle product<h3>Test files</h3>app/code/Magento/Bundle/Test/Mftf/Test/AdminEditRelatedBundleProductTest.xml<br>")
 * @TestCaseId("MC-3342")
 * @group Bundle
 */
class AdminEditRelatedBundleProductTestCest
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
		$I->comment("Admin login");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->createEntity("simpleProduct0", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct0
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct1
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete the bundled product");
		$I->comment("Entering Action Group [deleteBundle] DeleteProductUsingProductGridActionGroup");
		$I->comment("TODO use other action group for filtering grid when MQE-539 is implemented");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDeleteBundle
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDeleteBundle
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDeleteBundleWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDeleteBundle
		$I->fillField("input.admin__control-text[name='sku']", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFilterDeleteBundle
		$I->fillField("input.admin__control-text[name='name']", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFilterDeleteBundle
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteBundleWaitForPageLoad
		$I->see("bundleproduct" . msq("BundleProduct"), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDeleteBundle
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDeleteBundle
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDeleteBundle
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDeleteBundleWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Delete']"); // stepKey: clickDeleteActionDeleteBundle
		$I->waitForPageLoad(30); // stepKey: clickDeleteActionDeleteBundleWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm h1.modal-title", 30); // stepKey: waitForConfirmModalDeleteBundle
		$I->click(".modal-popup.confirm button.action-accept"); // stepKey: confirmProductDeleteDeleteBundle
		$I->waitForPageLoad(60); // stepKey: confirmProductDeleteDeleteBundleWaitForPageLoad
		$I->comment("Exiting Action Group [deleteBundle] DeleteProductUsingProductGridActionGroup");
		$I->comment("Logging out");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->deleteEntity("simpleProduct0", "hook"); // stepKey: deleteSimpleProduct0
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
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
	 * @Stories({"Create/Edit bundle product in Admin"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEditRelatedBundleProductTest(AcceptanceTester $I)
	{
		$I->comment("Create a bundle product");
		$I->comment("Entering Action Group [visitAdminProductPageBundle] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPageBundle
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPageBundle
		$I->comment("Exiting Action Group [visitAdminProductPageBundle] AdminOpenProductIndexPageActionGroup");
		$I->comment("Entering Action Group [goToCreateBundleProduct] GoToCreateProductPageActionGroup");
		$I->click(".action-toggle.primary.add"); // stepKey: clickAddProductToggleGoToCreateBundleProduct
		$I->waitForPageLoad(30); // stepKey: clickAddProductToggleGoToCreateBundleProductWaitForPageLoad
		$I->waitForElementVisible(".item[data-ui-id='products-list-add-new-product-button-item-bundle']", 30); // stepKey: waitForAddProductDropdownGoToCreateBundleProduct
		$I->click(".item[data-ui-id='products-list-add-new-product-button-item-bundle']"); // stepKey: clickAddProductTypeGoToCreateBundleProduct
		$I->waitForPageLoad(30); // stepKey: waitForCreateProductPageLoadGoToCreateBundleProduct
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/new/set/4/type/bundle/"); // stepKey: seeNewProductUrlGoToCreateBundleProduct
		$I->see("New Product", ".page-header h1.page-title"); // stepKey: seeNewProductTitleGoToCreateBundleProduct
		$I->comment("Exiting Action Group [goToCreateBundleProduct] GoToCreateProductPageActionGroup");
		$I->comment("Entering Action Group [fillBundleProductNameAndSku] FillProductNameAndSkuInProductFormActionGroup");
		$I->fillField(".admin__field[data-index=name] input", "BundleProduct" . msq("BundleProduct")); // stepKey: fillProductNameFillBundleProductNameAndSku
		$I->fillField(".admin__field[data-index=sku] input", "bundleproduct" . msq("BundleProduct")); // stepKey: fillProductSkuFillBundleProductNameAndSku
		$I->comment("Exiting Action Group [fillBundleProductNameAndSku] FillProductNameAndSkuInProductFormActionGroup");
		$I->comment("Entering Action Group [addRelatedProduct0] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProduct0WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct0
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProduct0WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProduct0WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct0
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct0', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct0
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProduct0WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct0
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProduct0WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProduct0WaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct0
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProduct0WaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct0] AddRelatedProductBySkuActionGroup");
		$I->comment("Save the product");
		$I->comment("Entering Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButton
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButton
		$I->comment("Exiting Action Group [clickSaveButton] AdminProductFormSaveActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShown
		$I->comment("Entering Action Group [addRelatedProduct1] AddRelatedProductBySkuActionGroup");
		$I->comment("Scroll up to avoid error");
		$I->scrollTo("//div[@data-index='related']", 0, -100); // stepKey: scrollToAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: scrollToAddRelatedProduct1WaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedUpSellCrossSellAddRelatedProduct1
		$I->click("button[data-index='button_related']"); // stepKey: clickAddRelatedProductButtonAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: clickAddRelatedProductButtonAddRelatedProduct1WaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersAddRelatedProduct1WaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersAddRelatedProduct1
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('simpleProduct1', 'sku', 'test')); // stepKey: fillProductSkuFilterAddRelatedProduct1
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersAddRelatedProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddRelatedProduct1
		$I->click(".modal-slide table.data-grid tr.data-row:nth-child(1) td:nth-child(1)"); // stepKey: selectProductAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: selectProductAddRelatedProduct1WaitForPageLoad
		$I->click("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]"); // stepKey: addRelatedProductSelectedAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: addRelatedProductSelectedAddRelatedProduct1WaitForPageLoad
		$I->waitForElementNotVisible("//aside[contains(@class, 'related_modal')]//button[contains(@class, 'action-primary')]", 30); // stepKey: waitForElementNotVisibleAddRelatedProduct1
		$I->waitForPageLoad(30); // stepKey: waitForElementNotVisibleAddRelatedProduct1WaitForPageLoad
		$I->comment("Exiting Action Group [addRelatedProduct1] AddRelatedProductBySkuActionGroup");
		$I->comment("Remove previous related product");
		$I->click("//span[text()='Related Products']//..//..//..//span[text()='" . $I->retrieveEntityField('simpleProduct0', 'sku', 'test') . "']//..//..//..//..//..//button[@class='action-delete']"); // stepKey: removeRelatedProduct
		$I->comment("Save the product");
		$I->comment("Entering Action Group [clickSaveButtonAfterEdit] AdminProductFormSaveActionGroup");
		$I->click("#save-button"); // stepKey: saveProductClickSaveButtonAfterEdit
		$I->waitForPageLoad(30); // stepKey: saveProductClickSaveButtonAfterEditWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductSavingClickSaveButtonAfterEdit
		$I->comment("Exiting Action Group [clickSaveButtonAfterEdit] AdminProductFormSaveActionGroup");
		$I->see("You saved the product.", ".message-success"); // stepKey: messageYouSavedTheProductIsShownAgain
		$I->comment("See related product in admin");
		$I->scrollTo("//div[@data-index='related']"); // stepKey: scrollTo
		$I->waitForPageLoad(30); // stepKey: scrollToWaitForPageLoad
		$I->conditionalClick("//div[@data-index='related']", "//div[@data-index='related']//div[contains(@class, '_show')]", false); // stepKey: openDropDownIfClosedRelatedSee
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test'), "//span[@data-index='name']"); // stepKey: seeRelatedProduct
		$runCronIndexer = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCronIndexer
		$I->comment($runCronIndexer);
		$I->comment("See related product in storefront");
		$I->amOnPage("bundleproduct" . msq("BundleProduct") . ".html"); // stepKey: goToStorefront
		$I->waitForPageLoad(30); // stepKey: waitForStorefront
		$I->see($I->retrieveEntityField('simpleProduct1', 'name', 'test')); // stepKey: seeRelatedProductInStorefront
	}
}
