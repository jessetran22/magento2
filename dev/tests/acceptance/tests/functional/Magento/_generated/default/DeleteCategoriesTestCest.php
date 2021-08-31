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
 * @Title("MAGETWO-46344: Admin should be able to delete the default root category and subcategories and still see products in the storefront")
 * @Description("Admin should be able to delete the default root category and subcategories and still see products in the storefront<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/DeleteCategoriesTest.xml<br>")
 * @TestCaseId("MAGETWO-46344")
 * @group testNotIsolated
 */
class DeleteCategoriesTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCategoryC", "hook", "_defaultCategory", [], []); // stepKey: createCategoryC
		$I->createEntity("createProduct1", "hook", "productWithDescription", ["createCategoryC"], []); // stepKey: createProduct1
		$I->createEntity("createSubCategory", "hook", "SubCategoryWithParent", ["createCategoryC"], []); // stepKey: createSubCategory
		$I->createEntity("createProduct2", "hook", "productWithDescription", ["createSubCategory"], []); // stepKey: createProduct2
		$I->createEntity("createCategoryB", "hook", "_defaultCategory", [], []); // stepKey: createCategoryB
		$I->createEntity("createProduct3", "hook", "productWithDescription", ["createCategoryB"], []); // stepKey: createProduct3
		$I->createEntity("createNewRootCategoryA", "hook", "NewRootCategory", [], []); // stepKey: createNewRootCategoryA
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
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createProduct3", "hook"); // stepKey: deleteProduct3
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
	 * @Features({"Catalog"})
	 * @Stories({"Delete categories"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DeleteCategoriesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->comment("Entering Action Group [navigateToCategoryPage1] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToCategoryPage1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToCategoryPage1
		$I->comment("Exiting Action Group [navigateToCategoryPage1] AdminOpenCategoryPageActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createNewRootCategoryA', 'name', 'test') . "')]"); // stepKey: openNewRootCategory
		$I->waitForPageLoad(30); // stepKey: openNewRootCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageCategoryLoadAfterClickOnNewRootCategory
		$I->seeElement(".page-actions-inner #delete"); // stepKey: assertDeleteButtonIsPresent
		$I->waitForPageLoad(30); // stepKey: assertDeleteButtonIsPresentWaitForPageLoad
		$I->comment("Move categories from Default Category to NewRootCategory.");
		$I->comment("Entering Action Group [MoveCategoryBToNewRootCategory] MoveCategoryActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllCategoriesTreeMoveCategoryBToNewRootCategory
		$I->waitForAjaxLoad(30); // stepKey: waitForCategoriesExpandMoveCategoryBToNewRootCategory
		$I->dragAndDrop("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]", "//a/span[contains(text(), '" . $I->retrieveEntityField('createNewRootCategoryA', 'name', 'test') . "')]"); // stepKey: moveCategoryMoveCategoryBToNewRootCategory
		$I->waitForPageLoad(30); // stepKey: moveCategoryMoveCategoryBToNewRootCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForWarningMessageVisibleMoveCategoryBToNewRootCategory
		$I->see("This operation can take a long time", "aside.confirm div.modal-content"); // stepKey: seeWarningMessageMoveCategoryBToNewRootCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopupMoveCategoryBToNewRootCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageReloadMoveCategoryBToNewRootCategory
		$I->comment("Exiting Action Group [MoveCategoryBToNewRootCategory] MoveCategoryActionGroup");
		$I->comment("Entering Action Group [MoveCategoryCToNewRootCategory] MoveCategoryActionGroup");
		$I->click(".tree-actions a:last-child"); // stepKey: expandAllCategoriesTreeMoveCategoryCToNewRootCategory
		$I->waitForAjaxLoad(30); // stepKey: waitForCategoriesExpandMoveCategoryCToNewRootCategory
		$I->dragAndDrop("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]", "//a/span[contains(text(), '" . $I->retrieveEntityField('createNewRootCategoryA', 'name', 'test') . "')]"); // stepKey: moveCategoryMoveCategoryCToNewRootCategory
		$I->waitForPageLoad(30); // stepKey: moveCategoryMoveCategoryCToNewRootCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForWarningMessageVisibleMoveCategoryCToNewRootCategory
		$I->see("This operation can take a long time", "aside.confirm div.modal-content"); // stepKey: seeWarningMessageMoveCategoryCToNewRootCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: clickOkButtonOnWarningPopupMoveCategoryCToNewRootCategory
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageReloadMoveCategoryCToNewRootCategory
		$I->comment("Exiting Action Group [MoveCategoryCToNewRootCategory] MoveCategoryActionGroup");
		$I->comment("Change root category for Main Website Store.");
		$I->comment("Entering Action Group [s1] AdminSystemStoreOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToSystemStoreS1
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminSystemStoreLoadS1
		$I->comment("Exiting Action Group [s1] AdminSystemStoreOpenPageActionGroup");
		$I->click("button[title='Reset Filter']"); // stepKey: s2
		$I->waitForPageLoad(30); // stepKey: s2WaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: waitForPageAdminStoresGridLoadAfterResetButton
		$I->fillField("#storeGrid_filter_group_title", "Main Website Store"); // stepKey: s4
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: s5
		$I->waitForPageLoad(30); // stepKey: s5WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminStoresGridLoadAfterSearchButton
		$I->click(".col-group_title>a"); // stepKey: s7
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminStoresGroupEditLoad
		$I->selectOption("#group_root_category_id", "NewRootCategory" . msq("NewRootCategory")); // stepKey: setNewCategoryForStoreGroup
		$I->click("#save"); // stepKey: clickSaveStoreGroup
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalSaveStoreGroup
		$I->waitForPageLoad(60); // stepKey: waitForModalSaveStoreGroupWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarning
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: acceptModal
		$I->waitForPageLoad(60); // stepKey: acceptModalWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_store_title", 30); // stepKey: waitForPageAdminStoresGridReload
		$I->waitForPageLoad(90); // stepKey: waitForPageAdminStoresGridReloadWaitForPageLoad
		$I->see("You saved the store."); // stepKey: seeSavedMessage
		$I->comment("@TODO: Uncomment commented below code after MQE-903 is fixed");
		$I->comment("Perform cli reindex.");
		$I->comment("<actionGroup ref=\"CliIndexerReindexActionGroup\" stepKey=\"reindex\">");
		$I->comment("<argument name=\"indices\" value=\"\"/>");
		$I->comment("</actionGroup>");
		$I->comment("Delete Default Root Category.");
		$I->comment("Entering Action Group [navigateToCategoryPageAfterCLIReindexCommand] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToCategoryPageAfterCLIReindexCommand
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToCategoryPageAfterCLIReindexCommand
		$I->comment("Exiting Action Group [navigateToCategoryPageAfterCLIReindexCommand] AdminOpenCategoryPageActionGroup");
		$I->click("//a/span[contains(text(), 'Default Category')]"); // stepKey: clickOnDefaultRootCategory
		$I->waitForPageLoad(30); // stepKey: clickOnDefaultRootCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageDefaultCategoryEditLoad
		$I->seeElement(".page-actions-inner #delete"); // stepKey: assertDeleteButtonIsPresent1
		$I->waitForPageLoad(30); // stepKey: assertDeleteButtonIsPresent1WaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: DeleteDefaultRootCategory
		$I->waitForPageLoad(30); // stepKey: DeleteDefaultRootCategoryWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer .action-primary", 30); // stepKey: waitForModalDeleteDefaultRootCategory
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: acceptModal1
		$I->waitForElementVisible(".message-success", 30); // stepKey: waitForPageReloadAfterDeleteDefaultCategory
		$I->comment("Verify categories 1 and 3 their products.");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("@TODO: Uncomment commented below code after MQE-903 is fixed");
		$I->comment("<click selector=\"\{\{StorefrontHeaderSection.NavigationCategoryByName(\$\$createCategoryC.name\$\$)\}\}\" stepKey=\"browseClickCategoryC\"/>");
		$I->comment("<actionGroup ref=\"StorefrontCheckCategoryActionGroup\" stepKey=\"browseAssertCategoryC\">");
		$I->comment("<argument name=\"category\" value=\"\$\$createCategoryC\$\$\"/>");
		$I->comment("<argument name=\"productCount\" value=\"2\"/>");
		$I->comment("</actionGroup>");
		$I->comment("<actionGroup ref=\"StorefrontCheckCategorySimpleProductActionGroup\" stepKey=\"browseAssertCategoryProduct1\">");
		$I->comment("<argument name=\"product\" value=\"\$\$createProduct1\$\$\"/>");
		$I->comment("</actionGroup>");
		$I->moveMouseOver("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]]"); // stepKey: hoverCategory
		$I->waitForPageLoad(30); // stepKey: hoverCategoryWaitForPageLoad
		$I->waitForElementVisible("//nav//a[span[contains(., '" . $I->retrieveEntityField('createSubCategory', 'name', 'test') . "')]]", 30); // stepKey: waitForSubcategory
		$I->waitForPageLoad(30); // stepKey: waitForSubcategoryWaitForPageLoad
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createSubCategory', 'name', 'test') . "')]]"); // stepKey: browseClickSubCategory
		$I->waitForPageLoad(30); // stepKey: browseClickSubCategoryWaitForPageLoad
		$I->comment("Entering Action Group [browseAssertSubcategory] StorefrontCheckCategoryActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createSubCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlBrowseAssertSubcategory
		$I->seeInTitle($I->retrieveEntityField('createSubCategory', 'name', 'test')); // stepKey: assertCategoryNameInTitleBrowseAssertSubcategory
		$I->see($I->retrieveEntityField('createSubCategory', 'name', 'test'), "#page-title-heading span"); // stepKey: assertCategoryNameBrowseAssertSubcategory
		$I->see("1", "#toolbar-amount span"); // stepKey: assertProductCountBrowseAssertSubcategory
		$I->comment("Exiting Action Group [browseAssertSubcategory] StorefrontCheckCategoryActionGroup");
		$I->comment("Entering Action Group [browseAssertCategoryProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]", 30); // stepKey: waitForProductBrowseAssertCategoryProduct2
		$I->seeElement("//main//li//a[contains(text(), '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]"); // stepKey: assertProductNameBrowseAssertCategoryProduct2
		$I->see("$" . $I->retrieveEntityField('createProduct2', 'price', 'test') . ".00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: AssertProductPriceBrowseAssertCategoryProduct2
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductBrowseAssertCategoryProduct2
		$I->seeElement("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct2', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: AssertAddToCartBrowseAssertCategoryProduct2
		$I->comment("Exiting Action Group [browseAssertCategoryProduct2] StorefrontCheckCategorySimpleProductActionGroup");
		$I->comment("@TODO: Uncomment commented below code after MQE-903 is fixed");
		$I->comment("<actionGroup ref=\"StorefrontCheckCategoryActionGroup\" stepKey=\"browseAssertCategoryB\">");
		$I->comment("<argument name=\"category\" value=\"\$\$createCategoryB\$\$\"/>");
		$I->comment("<argument name=\"productCount\" value=\"1\"/>");
		$I->comment("</actionGroup>");
		$I->comment("<actionGroup ref=\"StorefrontCheckCategorySimpleProductActionGroup\" stepKey=\"browseAssertCategoryProduct3\">");
		$I->comment("<argument name=\"product\" value=\"\$\$createProduct3\$\$\"/>");
		$I->comment("</actionGroup>");
		$I->comment("Delete Categories 1(with subcategory) and 3.");
		$I->comment("Entering Action Group [navigateToCategoryPageAfterStoreFrontCategoryAssertions] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToCategoryPageAfterStoreFrontCategoryAssertions
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToCategoryPageAfterStoreFrontCategoryAssertions
		$I->comment("Exiting Action Group [navigateToCategoryPageAfterStoreFrontCategoryAssertions] AdminOpenCategoryPageActionGroup");
		$I->comment("Entering Action Group [deleteCategoryC] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCategoryC
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCategoryC
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkDeleteCategoryC
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCategoryCWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCategoryC
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCategoryCWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCategoryC
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCategoryC
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCategoryC
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCategoryC
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCategoryC
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCategoryC
		$I->dontSee("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCategoryC
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCategoryCWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCategoryC] DeleteCategoryActionGroup");
		$I->comment("Entering Action Group [deleteCategoryB] DeleteCategoryActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: goToCategoryPageDeleteCategoryB
		$I->waitForPageLoad(60); // stepKey: waitForCategoryPageLoadDeleteCategoryB
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]"); // stepKey: clickCategoryLinkDeleteCategoryB
		$I->waitForPageLoad(30); // stepKey: clickCategoryLinkDeleteCategoryBWaitForPageLoad
		$I->click(".page-actions-inner #delete"); // stepKey: clickDeleteDeleteCategoryB
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCategoryBWaitForPageLoad
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitForConfirmationModalDeleteCategoryB
		$I->see("Are you sure you want to delete this category?", "aside.confirm div.modal-content"); // stepKey: seeDeleteConfirmationMessageDeleteCategoryB
		$I->click("aside.confirm .modal-footer .action-primary"); // stepKey: confirmDeleteDeleteCategoryB
		$I->waitForPageLoad(60); // stepKey: waitForDeleteToFinishDeleteCategoryB
		$I->see("You deleted the category."); // stepKey: seeDeleteSuccessDeleteCategoryB
		$I->click(".tree-actions a:last-child"); // stepKey: expandToSeeAllCategoriesDeleteCategoryB
		$I->dontSee("//a/span[contains(text(), '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]"); // stepKey: dontSeeCategoryInTreeDeleteCategoryB
		$I->waitForPageLoad(30); // stepKey: dontSeeCategoryInTreeDeleteCategoryBWaitForPageLoad
		$I->comment("Exiting Action Group [deleteCategoryB] DeleteCategoryActionGroup");
		$I->comment("Verify categories 1 and 3 are absent");
		$I->comment("Entering Action Group [goToHomePage1] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage1
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage1
		$I->comment("Exiting Action Group [goToHomePage1] StorefrontOpenHomePageActionGroup");
		$I->dontSee("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryB', 'name', 'test') . "')]]"); // stepKey: browseClickCategoryB
		$I->waitForPageLoad(30); // stepKey: browseClickCategoryBWaitForPageLoad
		$I->dontSee("//nav//a[span[contains(., '" . $I->retrieveEntityField('createCategoryC', 'name', 'test') . "')]]"); // stepKey: browseClickCategoryC
		$I->waitForPageLoad(30); // stepKey: browseClickCategoryCWaitForPageLoad
		$I->comment("Verify products 1-3 are available on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProduct1Page
		$I->waitForPageLoad(30); // stepKey: product1WaitForPageLoad
		$I->comment("Entering Action Group [browseAssertProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlBrowseAssertProduct1Page
		$I->seeInTitle($I->retrieveEntityField('createProduct1', 'name', 'test')); // stepKey: AssertProductNameInTitleBrowseAssertProduct1Page
		$I->see($I->retrieveEntityField('createProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameBrowseAssertProduct1Page
		$I->see($I->retrieveEntityField('createProduct1', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuBrowseAssertProduct1Page
		$I->see("$" . $I->retrieveEntityField('createProduct1', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceBrowseAssertProduct1Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockBrowseAssertProduct1Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartBrowseAssertProduct1Page
		$I->see($I->retrieveEntityField('createProduct1', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionBrowseAssertProduct1Page
		$I->see($I->retrieveEntityField('createProduct1', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionBrowseAssertProduct1Page
		$I->comment("Exiting Action Group [browseAssertProduct1Page] StorefrontCheckSimpleProductActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProduct2Page
		$I->waitForPageLoad(30); // stepKey: product2WaitForPageLoad
		$I->comment("Entering Action Group [browseAssertProduct2Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlBrowseAssertProduct2Page
		$I->seeInTitle($I->retrieveEntityField('createProduct2', 'name', 'test')); // stepKey: AssertProductNameInTitleBrowseAssertProduct2Page
		$I->see($I->retrieveEntityField('createProduct2', 'name', 'test'), ".base"); // stepKey: assertProductNameBrowseAssertProduct2Page
		$I->see($I->retrieveEntityField('createProduct2', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuBrowseAssertProduct2Page
		$I->see("$" . $I->retrieveEntityField('createProduct2', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceBrowseAssertProduct2Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockBrowseAssertProduct2Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartBrowseAssertProduct2Page
		$I->see($I->retrieveEntityField('createProduct2', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionBrowseAssertProduct2Page
		$I->see($I->retrieveEntityField('createProduct2', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionBrowseAssertProduct2Page
		$I->comment("Exiting Action Group [browseAssertProduct2Page] StorefrontCheckSimpleProductActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct3', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProduct3Page
		$I->waitForPageLoad(30); // stepKey: product3WaitForPageLoad
		$I->comment("Entering Action Group [browseAssertProduct3Page] StorefrontCheckSimpleProductActionGroup");
		$I->seeInCurrentUrl("/" . $I->retrieveEntityField('createProduct3', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: checkUrlBrowseAssertProduct3Page
		$I->seeInTitle($I->retrieveEntityField('createProduct3', 'name', 'test')); // stepKey: AssertProductNameInTitleBrowseAssertProduct3Page
		$I->see($I->retrieveEntityField('createProduct3', 'name', 'test'), ".base"); // stepKey: assertProductNameBrowseAssertProduct3Page
		$I->see($I->retrieveEntityField('createProduct3', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuBrowseAssertProduct3Page
		$I->see("$" . $I->retrieveEntityField('createProduct3', 'price', 'test') . ".00", "div.price-box.price-final_price"); // stepKey: assertProductPriceBrowseAssertProduct3Page
		$I->see("IN STOCK", ".stock[title=Availability]>span"); // stepKey: assertInStockBrowseAssertProduct3Page
		$I->seeElement("button#product-addtocart-button"); // stepKey: assertAddToCartBrowseAssertProduct3Page
		$I->see($I->retrieveEntityField('createProduct3', 'custom_attributes[description]', 'test'), "#description .value"); // stepKey: assertProductDescriptionBrowseAssertProduct3Page
		$I->see($I->retrieveEntityField('createProduct3', 'custom_attributes[short_description]', 'test'), "//div[@class='product attribute overview']//div[@class='value']"); // stepKey: assertProductShortDescriptionBrowseAssertProduct3Page
		$I->comment("Exiting Action Group [browseAssertProduct3Page] StorefrontCheckSimpleProductActionGroup");
		$I->comment("Rename New Root Category to Default category");
		$I->comment("Entering Action Group [navigateToCategoryPageAfterStoreFrontProductsAssertions] AdminOpenCategoryPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/category/"); // stepKey: openAdminCategoryIndexPageNavigateToCategoryPageAfterStoreFrontProductsAssertions
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageToLoadNavigateToCategoryPageAfterStoreFrontProductsAssertions
		$I->comment("Exiting Action Group [navigateToCategoryPageAfterStoreFrontProductsAssertions] AdminOpenCategoryPageActionGroup");
		$I->click("//a/span[contains(text(), '" . $I->retrieveEntityField('createNewRootCategoryA', 'name', 'test') . "')]"); // stepKey: clickOnNewRootCategoryA
		$I->waitForPageLoad(30); // stepKey: clickOnNewRootCategoryAWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageNewRootCategoryALoad
		$I->fillField("input[name='name']", "Default Category"); // stepKey: enterCategoryNameAsDefaultCategory
		$I->comment("Entering Action Group [saveCategoryDefaultCategory] AdminSaveCategoryActionGroup");
		$I->click(".page-actions-inner #save"); // stepKey: saveCategoryWithProductsSaveCategoryDefaultCategory
		$I->waitForPageLoad(30); // stepKey: saveCategoryWithProductsSaveCategoryDefaultCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategorySavedSaveCategoryDefaultCategory
		$I->comment("Exiting Action Group [saveCategoryDefaultCategory] AdminSaveCategoryActionGroup");
		$I->seeElement(".message-success"); // stepKey: assertSuccessMessageAfterSaveDefaultCategory
	}
}
