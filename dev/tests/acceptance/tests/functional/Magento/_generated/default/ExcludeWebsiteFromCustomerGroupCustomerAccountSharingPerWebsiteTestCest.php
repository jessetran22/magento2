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
 * @Title("MC-41141: Exclude Website From Customer Group With Account Sharing Per Website")
 * @Description("Exclude websites from Customer Group with Customer Accounts Sharing per Website<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/ExcludeWebsiteFromCustomerGroupCustomerAccountSharingPerWebsiteTest.xml<br>")
 * @TestCaseId("MC-41141")
 * @group customers
 */
class ExcludeWebsiteFromCustomerGroupCustomerAccountSharingPerWebsiteTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Set indexer on save");
		$setIndexerMode = $I->magentoCLI("indexer:set-mode", 60, "realtime"); // stepKey: setIndexerMode
		$I->comment($setIndexerMode);
		$I->comment("Create French Root Category with its Subcategory");
		$I->createEntity("createFrenchRootCategory", "hook", "NewRootCategory", [], []); // stepKey: createFrenchRootCategory
		$I->createEntity("createFrenchSubcategory", "hook", "SimpleRootSubCategory", ["createFrenchRootCategory"], []); // stepKey: createFrenchSubcategory
		$I->comment("Create subcategory to the Default Root Category");
		$I->createEntity("createDefaultSubcategory", "hook", "SimpleSubCategory", [], []); // stepKey: createDefaultSubcategory
		$I->comment("Create 3 products");
		$I->createEntity("simpleMainProduct", "hook", "SimpleProduct2", [], []); // stepKey: simpleMainProduct
		$I->createEntity("simpleFrenchProduct", "hook", "SimpleProduct2", [], []); // stepKey: simpleFrenchProduct
		$I->createEntity("simpleCommonProduct", "hook", "SimpleProduct2", [], []); // stepKey: simpleCommonProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Create French Website, Store, & Store View");
		$I->comment("Entering Action Group [createWebsiteFR] AdminCreateWebsiteActionGroup");
		$I->comment("Admin creates new custom website");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newWebsite"); // stepKey: navigateToNewWebsitePageCreateWebsiteFR
		$I->waitForPageLoad(30); // stepKey: waitForStoresPageLoadCreateWebsiteFR
		$I->comment("Create Website");
		$I->fillField("#website_name", "Second Website" . msq("customWebsite")); // stepKey: enterWebsiteNameCreateWebsiteFR
		$I->fillField("#website_code", "second_website" . msq("customWebsite")); // stepKey: enterWebsiteCodeCreateWebsiteFR
		$I->click("#save"); // stepKey: clickSaveWebsiteCreateWebsiteFR
		$I->waitForPageLoad(60); // stepKey: clickSaveWebsiteCreateWebsiteFRWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_website_title", 30); // stepKey: waitForStoreGridToReloadCreateWebsiteFR
		$I->see("You saved the website."); // stepKey: seeSavedMessageCreateWebsiteFR
		$I->comment("Exiting Action Group [createWebsiteFR] AdminCreateWebsiteActionGroup");
		$I->comment("Entering Action Group [createStoreFR] CreateCustomStoreActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnAdminSystemStorePageCreateStoreFR
		$I->waitForPageLoad(30); // stepKey: waitForSystemStorePageCreateStoreFR
		$I->click("#add_group"); // stepKey: selectCreateStoreCreateStoreFR
		$I->waitForPageLoad(30); // stepKey: selectCreateStoreCreateStoreFRWaitForPageLoad
		$I->selectOption("#group_website_id", "Second Website" . msq("customWebsite")); // stepKey: selectMainWebsiteCreateStoreFR
		$I->fillField("#group_name", "FR" . msq("customStoreFR")); // stepKey: fillStoreNameCreateStoreFR
		$I->fillField("#group_code", "FR" . msq("customStoreFR")); // stepKey: fillStoreCodeCreateStoreFR
		$I->selectOption("#group_root_category_id", $I->retrieveEntityField('createFrenchRootCategory', 'name', 'hook')); // stepKey: selectStoreStatusCreateStoreFR
		$I->click("#save"); // stepKey: clickSaveStoreGroupCreateStoreFR
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreGroupCreateStoreFRWaitForPageLoad
		$I->waitForElementVisible("#storeGrid_filter_group_title", 30); // stepKey: waitForStoreGridReloadCreateStoreFR
		$I->see("You saved the store."); // stepKey: seeSavedMessageCreateStoreFR
		$I->comment("Exiting Action Group [createStoreFR] CreateCustomStoreActionGroup");
		$I->comment("Entering Action Group [createStoreViewFR] AdminCreateStoreViewActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/newStore"); // stepKey: navigateToNewStoreViewCreateStoreViewFR
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateStoreViewFR
		$I->comment("Creating Store View");
		$I->comment("Create Store View");
		$I->selectOption("#store_group_id", "FR" . msq("customStoreFR")); // stepKey: selectStoreCreateStoreViewFR
		$I->fillField("#store_name", "FR" . msq("customStoreFR")); // stepKey: enterStoreViewNameCreateStoreViewFR
		$I->fillField("#store_code", "fr" . msq("customStoreFR")); // stepKey: enterStoreViewCodeCreateStoreViewFR
		$I->selectOption("#store_is_active", "Enabled"); // stepKey: setStatusCreateStoreViewFR
		$I->click("#save"); // stepKey: clickSaveStoreViewCreateStoreViewFR
		$I->waitForPageLoad(60); // stepKey: clickSaveStoreViewCreateStoreViewFRWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForModalCreateStoreViewFR
		$I->waitForPageLoad(60); // stepKey: waitForModalCreateStoreViewFRWaitForPageLoad
		$I->see("Warning message", "aside.confirm .modal-title"); // stepKey: seeWarningAboutTakingALongTimeToCompleteCreateStoreViewFR
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmModalCreateStoreViewFR
		$I->waitForPageLoad(60); // stepKey: confirmModalCreateStoreViewFRWaitForPageLoad
		$I->waitForText("You saved the store view.", 30, "#messages div.message-success"); // stepKey: seeSavedMessageCreateStoreViewFR
		$I->comment("Exiting Action Group [createStoreViewFR] AdminCreateStoreViewActionGroup");
		$I->comment("1. Open Admin > Catalog > Products > Default Product");
		$I->comment("Entering Action Group [goToDefaultProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleMainProduct', 'id', 'hook')); // stepKey: goToProductGoToDefaultProduct
		$I->comment("Exiting Action Group [goToDefaultProduct] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad1
		$I->comment("2. Assign SubCategory Of Additional Root Category to Default product. Save product");
		$I->comment("Entering Action Group [assignDefaultProduct] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("on edit Product page catalog/product/edit/id/\{\{product_id\}\}/");
		$I->click("div[data-index='category_ids']"); // stepKey: openDropDownAssignDefaultProduct
		$I->waitForPageLoad(30); // stepKey: openDropDownAssignDefaultProductWaitForPageLoad
		$I->checkOption("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('createDefaultSubcategory', 'name', 'hook') . "')]"); // stepKey: selectCategoryAssignDefaultProduct
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignDefaultProductWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickDoneAssignDefaultProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneAssignDefaultProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyCategoryAssignDefaultProduct
		$I->click("#save-button"); // stepKey: clickSaveAssignDefaultProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveAssignDefaultProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingProductAssignDefaultProduct
		$I->see("You saved the product.", "//div[@data-ui-id='messages-message-success']"); // stepKey: seeSuccessMessageAssignDefaultProduct
		$I->comment("Exiting Action Group [assignDefaultProduct] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("1. Open Admin > Catalog > Products > Additional Product");
		$I->comment("Entering Action Group [goToAdditionalProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleFrenchProduct', 'id', 'hook')); // stepKey: goToProductGoToAdditionalProduct
		$I->comment("Exiting Action Group [goToAdditionalProduct] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad2
		$I->comment("2. Assign subcategory of default root category to Additional product. Save product");
		$I->comment("Entering Action Group [assignAdditionalProduct] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("on edit Product page catalog/product/edit/id/\{\{product_id\}\}/");
		$I->click("div[data-index='category_ids']"); // stepKey: openDropDownAssignAdditionalProduct
		$I->waitForPageLoad(30); // stepKey: openDropDownAssignAdditionalProductWaitForPageLoad
		$I->checkOption("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('createFrenchSubcategory', 'name', 'hook') . "')]"); // stepKey: selectCategoryAssignAdditionalProduct
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignAdditionalProductWaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickDoneAssignAdditionalProduct
		$I->waitForPageLoad(30); // stepKey: clickDoneAssignAdditionalProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyCategoryAssignAdditionalProduct
		$I->click("#save-button"); // stepKey: clickSaveAssignAdditionalProduct
		$I->waitForPageLoad(30); // stepKey: clickSaveAssignAdditionalProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingProductAssignAdditionalProduct
		$I->see("You saved the product.", "//div[@data-ui-id='messages-message-success']"); // stepKey: seeSuccessMessageAssignAdditionalProduct
		$I->comment("Exiting Action Group [assignAdditionalProduct] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("3. Assign Additional Website to Additional product");
		$I->comment("Entering Action Group [selectAdditionalWebsiteInAdditionalProduct] SelectProductInWebsitesActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSelectAdditionalWebsiteInAdditionalProduct
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSelectAdditionalWebsiteInAdditionalProductWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "div[data-index='content']._show", false); // stepKey: expandSectionSelectAdditionalWebsiteInAdditionalProduct
		$I->waitForPageLoad(30); // stepKey: expandSectionSelectAdditionalWebsiteInAdditionalProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedSelectAdditionalWebsiteInAdditionalProduct
		$I->checkOption("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteSelectAdditionalWebsiteInAdditionalProduct
		$I->comment("Exiting Action Group [selectAdditionalWebsiteInAdditionalProduct] SelectProductInWebsitesActionGroup");
		$I->comment("Entering Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct2
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct2
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct2WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct2WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct2
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct2
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct2
		$I->comment("Exiting Action Group [saveProduct2] SaveProductFormActionGroup");
		$I->comment("1. Open Admin > Catalog > Products > Common Product");
		$I->comment("Entering Action Group [goToCommonProduct] AdminProductPageOpenByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/edit/id/" . $I->retrieveEntityField('simpleCommonProduct', 'id', 'hook')); // stepKey: goToProductGoToCommonProduct
		$I->comment("Exiting Action Group [goToCommonProduct] AdminProductPageOpenByIdActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoad3
		$I->comment("2. Assign product to Subcategory of Default and Additional Websites. Save product");
		$I->comment("Entering Action Group [assignCommonProduct1] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("on edit Product page catalog/product/edit/id/\{\{product_id\}\}/");
		$I->click("div[data-index='category_ids']"); // stepKey: openDropDownAssignCommonProduct1
		$I->waitForPageLoad(30); // stepKey: openDropDownAssignCommonProduct1WaitForPageLoad
		$I->checkOption("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('createDefaultSubcategory', 'name', 'hook') . "')]"); // stepKey: selectCategoryAssignCommonProduct1
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignCommonProduct1WaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickDoneAssignCommonProduct1
		$I->waitForPageLoad(30); // stepKey: clickDoneAssignCommonProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyCategoryAssignCommonProduct1
		$I->click("#save-button"); // stepKey: clickSaveAssignCommonProduct1
		$I->waitForPageLoad(30); // stepKey: clickSaveAssignCommonProduct1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingProductAssignCommonProduct1
		$I->see("You saved the product.", "//div[@data-ui-id='messages-message-success']"); // stepKey: seeSuccessMessageAssignCommonProduct1
		$I->comment("Exiting Action Group [assignCommonProduct1] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("Entering Action Group [assignCommonProduct2] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("on edit Product page catalog/product/edit/id/\{\{product_id\}\}/");
		$I->click("div[data-index='category_ids']"); // stepKey: openDropDownAssignCommonProduct2
		$I->waitForPageLoad(30); // stepKey: openDropDownAssignCommonProduct2WaitForPageLoad
		$I->checkOption("//*[@data-index='category_ids']//label[contains(., '" . $I->retrieveEntityField('createFrenchSubcategory', 'name', 'hook') . "')]"); // stepKey: selectCategoryAssignCommonProduct2
		$I->waitForPageLoad(30); // stepKey: selectCategoryAssignCommonProduct2WaitForPageLoad
		$I->click("//*[@data-index='category_ids']//button[@data-action='close-advanced-select']"); // stepKey: clickDoneAssignCommonProduct2
		$I->waitForPageLoad(30); // stepKey: clickDoneAssignCommonProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyCategoryAssignCommonProduct2
		$I->click("#save-button"); // stepKey: clickSaveAssignCommonProduct2
		$I->waitForPageLoad(30); // stepKey: clickSaveAssignCommonProduct2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSavingProductAssignCommonProduct2
		$I->see("You saved the product.", "//div[@data-ui-id='messages-message-success']"); // stepKey: seeSuccessMessageAssignCommonProduct2
		$I->comment("Exiting Action Group [assignCommonProduct2] AdminAssignCategoryToProductAndSaveActionGroup");
		$I->comment("3. Assign Additional Website to Additional product");
		$I->comment("Entering Action Group [selectAdditionalWebsiteInCommonProduct] SelectProductInWebsitesActionGroup");
		$I->scrollTo("div[data-index='websites']"); // stepKey: scrollToWebsitesSelectAdditionalWebsiteInCommonProduct
		$I->waitForPageLoad(30); // stepKey: scrollToWebsitesSelectAdditionalWebsiteInCommonProductWaitForPageLoad
		$I->conditionalClick("div[data-index='websites']", "div[data-index='content']._show", false); // stepKey: expandSectionSelectAdditionalWebsiteInCommonProduct
		$I->waitForPageLoad(30); // stepKey: expandSectionSelectAdditionalWebsiteInCommonProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageOpenedSelectAdditionalWebsiteInCommonProduct
		$I->checkOption("//label[contains(text(), 'Second Website" . msq("customWebsite") . "')]/parent::div//input[@type='checkbox']"); // stepKey: selectWebsiteSelectAdditionalWebsiteInCommonProduct
		$I->comment("Exiting Action Group [selectAdditionalWebsiteInCommonProduct] SelectProductInWebsitesActionGroup");
		$I->comment("Entering Action Group [saveProduct3] SaveProductFormActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollTopPageProductSaveProduct3
		$I->waitForElementVisible("#save-button", 30); // stepKey: waitForSaveProductButtonSaveProduct3
		$I->waitForPageLoad(30); // stepKey: waitForSaveProductButtonSaveProduct3WaitForPageLoad
		$I->click("#save-button"); // stepKey: clickSaveProductSaveProduct3
		$I->waitForPageLoad(30); // stepKey: clickSaveProductSaveProduct3WaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitProductSaveSuccessMessageSaveProduct3
		$I->dontSee(".message-warning"); // stepKey: dontSeeWarningMessageSaveProduct3
		$I->see("You saved the product.", "#messages div.message-success"); // stepKey: seeSaveConfirmationSaveProduct3
		$I->comment("Exiting Action Group [saveProduct3] SaveProductFormActionGroup");
		$I->comment("Create customer group Members");
		$I->createEntity("customerGroupMembers", "hook", "CustomCustomerGroup", [], []); // stepKey: customerGroupMembers
		$I->comment("Create customer group Family");
		$I->createEntity("customerGroupFamily", "hook", "CustomCustomerGroup", [], []); // stepKey: customerGroupFamily
		$I->comment("Create customer assigned to Main Website and to Members group");
		$I->createEntity("customerAssignedToMainWebsiteMembersGroup", "hook", "UsCustomerAssignedToNewCustomerGroup", ["customerGroupMembers"], []); // stepKey: customerAssignedToMainWebsiteMembersGroup
		$I->comment("Create customer assigned to Main Website and to Family group");
		$I->createEntity("customerAssignedToMainWebsiteFamilyGroup", "hook", "UsCustomerAssignedToNewCustomerGroup", ["customerGroupFamily"], []); // stepKey: customerAssignedToMainWebsiteFamilyGroup
		$I->comment("Create customer assigned to FR Website and to Members group");
		$I->createEntity("customerAssignedToFrenchWebsiteMembersGroup", "hook", "FrenchCustomerOneAssignedToNewCustomerGroup", ["customerGroupMembers"], []); // stepKey: customerAssignedToFrenchWebsiteMembersGroup
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customerAssignedToFrenchWebsiteMembersGroup', 'id', 'hook')); // stepKey: goToFRCustomerMembersGroupEditPage
		$I->waitForPageLoad(30); // stepKey: waitPageToLoad1
		$I->comment("Entering Action Group [clickOnAccountInformation1] AdminOpenAccountInformationTabFromCustomerEditPageActionGroup");
		$I->waitForElementVisible("#tab_customer", 30); // stepKey: waitForAccountInformationTabClickOnAccountInformation1
		$I->waitForPageLoad(30); // stepKey: waitForAccountInformationTabClickOnAccountInformation1WaitForPageLoad
		$I->click("#tab_customer"); // stepKey: clickAccountInformationTabClickOnAccountInformation1
		$I->waitForPageLoad(30); // stepKey: clickAccountInformationTabClickOnAccountInformation1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickOnAccountInformation1
		$I->comment("Exiting Action Group [clickOnAccountInformation1] AdminOpenAccountInformationTabFromCustomerEditPageActionGroup");
		$I->comment("Entering Action Group [selectWebsiteGroupStoreForFRCustomerMembersGroup] AdminCustomerSelectWebsiteGroupStoreActionGroup");
		$I->selectOption("//select[@name='customer[website_id]']", "Second Website" . msq("customWebsite")); // stepKey: selectWebSiteSelectWebsiteGroupStoreForFRCustomerMembersGroup
		$I->click("[name='customer[group_id]']"); // stepKey: clickToExpandGroupSelectWebsiteGroupStoreForFRCustomerMembersGroup
		$I->click("//label/span[text()='" . $I->retrieveEntityField('customerGroupMembers', 'code', 'hook') . "']|//select/option[text()='" . $I->retrieveEntityField('customerGroupMembers', 'code', 'hook') . "']"); // stepKey: clickToSelectCustomerGroupSelectWebsiteGroupStoreForFRCustomerMembersGroup
		$I->selectOption("//select[@name='customer[sendemail_store_id]']", "FR" . msq("customStoreFR")); // stepKey: selectStoreViewSelectWebsiteGroupStoreForFRCustomerMembersGroup
		$I->waitForElement("//select[@name='customer[sendemail_store_id]']", 30); // stepKey: waitForCustomerStoreViewExpandSelectWebsiteGroupStoreForFRCustomerMembersGroup
		$I->click("//button[@title='Save Customer']"); // stepKey: saveCustomerSelectWebsiteGroupStoreForFRCustomerMembersGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomersPageSelectWebsiteGroupStoreForFRCustomerMembersGroup
		$I->see("You saved the customer."); // stepKey: seeCustomerSaveSuccessMessageSelectWebsiteGroupStoreForFRCustomerMembersGroup
		$I->comment("Exiting Action Group [selectWebsiteGroupStoreForFRCustomerMembersGroup] AdminCustomerSelectWebsiteGroupStoreActionGroup");
		$I->comment("Create customer assigned to FR Website and to Family group");
		$I->createEntity("customerAssignedToFrenchWebsiteFamilyGroup", "hook", "FrenchCustomerTwoAssignedToNewCustomerGroup", ["customerGroupFamily"], []); // stepKey: customerAssignedToFrenchWebsiteFamilyGroup
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('customerAssignedToFrenchWebsiteFamilyGroup', 'id', 'hook')); // stepKey: goToFRCustomerFamilyGroupEditPage
		$I->waitForPageLoad(30); // stepKey: waitPageToLoad2
		$I->comment("Entering Action Group [clickOnAccountInformation2] AdminOpenAccountInformationTabFromCustomerEditPageActionGroup");
		$I->waitForElementVisible("#tab_customer", 30); // stepKey: waitForAccountInformationTabClickOnAccountInformation2
		$I->waitForPageLoad(30); // stepKey: waitForAccountInformationTabClickOnAccountInformation2WaitForPageLoad
		$I->click("#tab_customer"); // stepKey: clickAccountInformationTabClickOnAccountInformation2
		$I->waitForPageLoad(30); // stepKey: clickAccountInformationTabClickOnAccountInformation2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickOnAccountInformation2
		$I->comment("Exiting Action Group [clickOnAccountInformation2] AdminOpenAccountInformationTabFromCustomerEditPageActionGroup");
		$I->comment("Entering Action Group [selectWebsiteGroupStoreForFRCustomerFamilyGroup] AdminCustomerSelectWebsiteGroupStoreActionGroup");
		$I->selectOption("//select[@name='customer[website_id]']", "Second Website" . msq("customWebsite")); // stepKey: selectWebSiteSelectWebsiteGroupStoreForFRCustomerFamilyGroup
		$I->click("[name='customer[group_id]']"); // stepKey: clickToExpandGroupSelectWebsiteGroupStoreForFRCustomerFamilyGroup
		$I->click("//label/span[text()='" . $I->retrieveEntityField('customerGroupFamily', 'code', 'hook') . "']|//select/option[text()='" . $I->retrieveEntityField('customerGroupFamily', 'code', 'hook') . "']"); // stepKey: clickToSelectCustomerGroupSelectWebsiteGroupStoreForFRCustomerFamilyGroup
		$I->selectOption("//select[@name='customer[sendemail_store_id]']", "FR" . msq("customStoreFR")); // stepKey: selectStoreViewSelectWebsiteGroupStoreForFRCustomerFamilyGroup
		$I->waitForElement("//select[@name='customer[sendemail_store_id]']", 30); // stepKey: waitForCustomerStoreViewExpandSelectWebsiteGroupStoreForFRCustomerFamilyGroup
		$I->click("//button[@title='Save Customer']"); // stepKey: saveCustomerSelectWebsiteGroupStoreForFRCustomerFamilyGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomersPageSelectWebsiteGroupStoreForFRCustomerFamilyGroup
		$I->see("You saved the customer."); // stepKey: seeCustomerSaveSuccessMessageSelectWebsiteGroupStoreForFRCustomerFamilyGroup
		$I->comment("Exiting Action Group [selectWebsiteGroupStoreForFRCustomerFamilyGroup] AdminCustomerSelectWebsiteGroupStoreActionGroup");
		$I->comment("Add store code to url");
		$I->comment("Entering Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPageAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddStoreCodeToUrls
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: expandUrlSectionTabAddStoreCodeToUrls
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrlAddStoreCodeToUrls
		$I->uncheckOption("#web_url_use_store_inherit"); // stepKey: uncheckUseSystemValueAddStoreCodeToUrls
		$I->selectOption("#web_url_use_store", "Yes"); // stepKey: enableStoreCodeAddStoreCodeToUrls
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsAddStoreCodeToUrls
		$I->click("#save"); // stepKey: saveConfigAddStoreCodeToUrls
		$I->waitForPageLoad(30); // stepKey: saveConfigAddStoreCodeToUrlsWaitForPageLoad
		$I->comment("Exiting Action Group [addStoreCodeToUrls] EnableWebUrlOptionsActionGroup");
		$I->comment("Set Customer Accounts Sharing to Per Website");
		$setConfigCustomerAccountToWebsite = $I->magentoCLI("config:set customer/account_share/scope 1", 60); // stepKey: setConfigCustomerAccountToWebsite
		$I->comment($setConfigCustomerAccountToWebsite);
		$cleanInvalidatedCaches = $I->magentoCLI("cache:clean config full_page", 60); // stepKey: cleanInvalidatedCaches
		$I->comment($cleanInvalidatedCaches);
		$I->comment("Reindex all indexers");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete website");
		$I->comment("Entering Action Group [deleteStoreUS] DeleteCustomWebsiteActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: amOnTheStorePageDeleteStoreUS
		$I->click("button[title='Reset Filter']"); // stepKey: clickOnResetButtonDeleteStoreUS
		$I->waitForPageLoad(30); // stepKey: clickOnResetButtonDeleteStoreUSWaitForPageLoad
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteFieldDeleteStoreUS
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonDeleteStoreUS
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonDeleteStoreUSWaitForPageLoad
		$I->see("Second Website" . msq("customWebsite"), "tr:nth-of-type(1) > .col-website_title > a"); // stepKey: verifyThatCorrectWebsiteFoundDeleteStoreUS
		$I->click("tr:nth-of-type(1) > .col-website_title > a"); // stepKey: clickEditExistingWebsiteDeleteStoreUS
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAfterWebsiteSelectedDeleteStoreUS
		$I->click("#delete"); // stepKey: clickDeleteWebsiteButtonOnEditStorePageDeleteStoreUS
		$I->waitForPageLoad(30); // stepKey: clickDeleteWebsiteButtonOnEditStorePageDeleteStoreUSWaitForPageLoad
		$I->selectOption("#store_create_backup", "No"); // stepKey: setCreateDbBackupToNoDeleteStoreUS
		$I->click("#delete"); // stepKey: clickDeleteButtonOnDeleteWebsitePageDeleteStoreUS
		$I->waitForPageLoad(120); // stepKey: clickDeleteButtonOnDeleteWebsitePageDeleteStoreUSWaitForPageLoad
		$I->see("You deleted the website.", "#messages div.message-success"); // stepKey: checkSuccessMessageDeleteStoreUS
		$I->comment("Exiting Action Group [deleteStoreUS] DeleteCustomWebsiteActionGroup");
		$I->comment("Delete root category and subcategory");
		$I->deleteEntity("createFrenchRootCategory", "hook"); // stepKey: deleteAdditionalRootCategory
		$I->deleteEntity("createDefaultSubcategory", "hook"); // stepKey: deleteSubCategoryOfDefaultRootCategory
		$I->comment("Delete products");
		$I->deleteEntity("simpleMainProduct", "hook"); // stepKey: deleteSimpleMainProduct
		$I->deleteEntity("simpleFrenchProduct", "hook"); // stepKey: deleteSimpleFrenchProduct
		$I->deleteEntity("simpleCommonProduct", "hook"); // stepKey: deleteSimpleCommonProduct
		$I->comment("Delete Main website customers");
		$I->deleteEntity("customerAssignedToMainWebsiteMembersGroup", "hook"); // stepKey: deleteMainWebsiteMembersGroupCustomer
		$I->deleteEntity("customerAssignedToMainWebsiteFamilyGroup", "hook"); // stepKey: deleteMainWebsiteFamilyGroupCustomer
		$I->comment("Delete FR Website customers");
		$I->deleteEntity("customerAssignedToFrenchWebsiteMembersGroup", "hook"); // stepKey: deleteFRWebsiteMembersGroupCustomer
		$I->deleteEntity("customerAssignedToFrenchWebsiteFamilyGroup", "hook"); // stepKey: deleteFRWebsiteFamilyGroupCustomer
		$I->comment("Delete customer group");
		$I->deleteEntity("customerGroupMembers", "hook"); // stepKey: deleteCustomerGroupMembers
		$I->deleteEntity("customerGroupFamily", "hook"); // stepKey: deleteCustomerGroupFamily
		$I->comment("Rollback config settings");
		$I->comment("Entering Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/web/"); // stepKey: navigateToWebConfigurationPagetoResetResetUrlOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2ResetUrlOption
		$I->conditionalClick("#web_url-head", "#web_url-head:not(.open)", true); // stepKey: closeUrlSectionTabResetUrlOption
		$I->waitForElementVisible("#web_url_use_store", 30); // stepKey: seeAddStoreCodeToUrl2ResetUrlOption
		$I->comment("<uncheckOption selector=\"\{\{UrlOptionsSection.systemValueForStoreCode\}\}\" stepKey=\"uncheckUseSystemValue\"/>");
		$I->selectOption("#web_url_use_store", "No"); // stepKey: enableStoreCodeResetUrlOption
		$I->checkOption("#web_url_use_store_inherit"); // stepKey: checkUseSystemValueResetUrlOption
		$I->click("#web_url-head"); // stepKey: collapseUrlOptionsResetUrlOption
		$I->click("#save"); // stepKey: saveConfigResetUrlOption
		$I->waitForPageLoad(30); // stepKey: saveConfigResetUrlOptionWaitForPageLoad
		$I->comment("Exiting Action Group [resetUrlOption] ResetWebUrlOptionsActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Reindex all indexers");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
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
	 * @Features({"Customer"})
	 * @Stories({"Exclude Website From Customer Group With Account Sharing Per Website"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ExcludeWebsiteFromCustomerGroupCustomerAccountSharingPerWebsiteTest(AcceptanceTester $I)
	{
		$I->comment("Grab new store view code");
		$I->comment("Entering Action Group [navigateToNewWebsitePage] AdminSystemStoreOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_store/"); // stepKey: navigateToSystemStoreNavigateToNewWebsitePage
		$I->waitForPageLoad(30); // stepKey: waitForPageAdminSystemStoreLoadNavigateToNewWebsitePage
		$I->comment("Exiting Action Group [navigateToNewWebsitePage] AdminSystemStoreOpenPageActionGroup");
		$I->fillField("#storeGrid_filter_website_title", "Second Website" . msq("customWebsite")); // stepKey: fillSearchWebsiteField
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButton
		$I->waitForPageLoad(30); // stepKey: clickSearchButtonWaitForPageLoad
		$I->click(".col-store_title>a"); // stepKey: clickFirstRow
		$grabStoreViewCode = $I->grabValueFrom("#store_code"); // stepKey: grabStoreViewCode
		$I->click("#back"); // stepKey: clickBack
		$I->waitForPageLoad(30); // stepKey: clickBackWaitForPageLoad
		$I->click("button[title='Reset Filter']"); // stepKey: clickResetButton
		$I->waitForPageLoad(30); // stepKey: clickResetButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStorePageLoad
		$I->comment("Go to FR website home page");
		$I->amOnPage("$grabStoreViewCode"); // stepKey: navigateToHomePageOfFRStore
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad
		$I->comment("Sign In FR Members Group customer using Sign In header Link");
		$I->comment("Entering Action Group [FrCustomerMembersGroupLogin] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->click("//header[@class='page-header']//li/a[contains(.,'Sign In')]"); // stepKey: clickSignInAccountLinkFrCustomerMembersGroupLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedFrCustomerMembersGroupLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsFrCustomerMembersGroupLogin
		$I->fillField("#email", $I->retrieveEntityField('customerAssignedToFrenchWebsiteMembersGroup', 'email', 'test')); // stepKey: fillEmailFrCustomerMembersGroupLogin
		$I->fillField("#pass", $I->retrieveEntityField('customerAssignedToFrenchWebsiteMembersGroup', 'password', 'test')); // stepKey: fillPasswordFrCustomerMembersGroupLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonFrCustomerMembersGroupLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonFrCustomerMembersGroupLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInFrCustomerMembersGroupLogin
		$I->comment("Exiting Action Group [FrCustomerMembersGroupLogin] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->comment("Assert simpleCommonProduct and simpleFrenchProduct in FR website and FR category product grid");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createFrenchSubcategory', 'name', 'test') . "')]]"); // stepKey: goToCategoryFR
		$I->waitForPageLoad(30); // stepKey: goToCategoryFRWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageFR
		$I->comment("Entering Action Group [assertProductFRInFR] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleFrenchProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductFRInFR
		$I->comment("Exiting Action Group [assertProductFRInFR] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertProductBothInUS_FR] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleCommonProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductBothInUS_FR
		$I->comment("Exiting Action Group [assertProductBothInUS_FR] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Customer log out");
		$I->comment("Entering Action Group [storefrontSignOut] StorefrontCustomStoreCustomerLogoutActionGroup");
		$I->amOnPage("/fr" . msq("customStoreFR") . "/customer/account/logout/"); // stepKey: storefrontSignOutStorefrontSignOut
		$I->waitForPageLoad(30); // stepKey: waitForSignOutStorefrontSignOut
		$I->comment("Exiting Action Group [storefrontSignOut] StorefrontCustomStoreCustomerLogoutActionGroup");
		$I->comment("Go to FR website home page");
		$I->amOnPage("$grabStoreViewCode"); // stepKey: navigateToHomePageOfFRStore2
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad2
		$I->comment("Sign In FR Family Group Customer using Sign In header Link");
		$I->comment("Entering Action Group [FrCustomerFamilyGroupLogin] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->click("//header[@class='page-header']//li/a[contains(.,'Sign In')]"); // stepKey: clickSignInAccountLinkFrCustomerFamilyGroupLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedFrCustomerFamilyGroupLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsFrCustomerFamilyGroupLogin
		$I->fillField("#email", $I->retrieveEntityField('customerAssignedToFrenchWebsiteFamilyGroup', 'email', 'test')); // stepKey: fillEmailFrCustomerFamilyGroupLogin
		$I->fillField("#pass", $I->retrieveEntityField('customerAssignedToFrenchWebsiteFamilyGroup', 'password', 'test')); // stepKey: fillPasswordFrCustomerFamilyGroupLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonFrCustomerFamilyGroupLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonFrCustomerFamilyGroupLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInFrCustomerFamilyGroupLogin
		$I->comment("Exiting Action Group [FrCustomerFamilyGroupLogin] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->comment("Assert simpleCommonProduct and simpleFrenchProduct in FR website and FR category product grid");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createFrenchSubcategory', 'name', 'test') . "')]]"); // stepKey: goToCategoryFR2
		$I->waitForPageLoad(30); // stepKey: goToCategoryFR2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageFR2
		$I->comment("Entering Action Group [assertProductFRInFR2] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleFrenchProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductFRInFR2
		$I->comment("Exiting Action Group [assertProductFRInFR2] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertProductBothInUS_FR2] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleCommonProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductBothInUS_FR2
		$I->comment("Exiting Action Group [assertProductBothInUS_FR2] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Customer log out");
		$I->comment("Entering Action Group [storefrontSignOut2] StorefrontCustomStoreCustomerLogoutActionGroup");
		$I->amOnPage("/fr" . msq("customStoreFR") . "/customer/account/logout/"); // stepKey: storefrontSignOutStorefrontSignOut2
		$I->waitForPageLoad(30); // stepKey: waitForSignOutStorefrontSignOut2
		$I->comment("Exiting Action Group [storefrontSignOut2] StorefrontCustomStoreCustomerLogoutActionGroup");
		$I->comment("Go to Main Website home page with Family Group customer");
		$I->comment("Entering Action Group [goToHomePage1] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage1
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage1
		$I->comment("Exiting Action Group [goToHomePage1] StorefrontOpenHomePageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad3
		$I->comment("Sign In Main Website Family Group Customer using Sign In header Link");
		$I->comment("Entering Action Group [MainWebsiteCustomerFamilyGroupLogin] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->click("//header[@class='page-header']//li/a[contains(.,'Sign In')]"); // stepKey: clickSignInAccountLinkMainWebsiteCustomerFamilyGroupLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedMainWebsiteCustomerFamilyGroupLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsMainWebsiteCustomerFamilyGroupLogin
		$I->fillField("#email", $I->retrieveEntityField('customerAssignedToMainWebsiteFamilyGroup', 'email', 'test')); // stepKey: fillEmailMainWebsiteCustomerFamilyGroupLogin
		$I->fillField("#pass", $I->retrieveEntityField('customerAssignedToMainWebsiteFamilyGroup', 'password', 'test')); // stepKey: fillPasswordMainWebsiteCustomerFamilyGroupLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonMainWebsiteCustomerFamilyGroupLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonMainWebsiteCustomerFamilyGroupLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInMainWebsiteCustomerFamilyGroupLogin
		$I->comment("Exiting Action Group [MainWebsiteCustomerFamilyGroupLogin] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->comment("Assert simpleCommonProduct and simpleMainProduct in Main Website website and Main category product grid");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createDefaultSubcategory', 'name', 'test') . "')]]"); // stepKey: goToCategoryMain1
		$I->waitForPageLoad(30); // stepKey: goToCategoryMain1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageMain1
		$I->comment("Entering Action Group [assertProductMainInMain1] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleMainProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductMainInMain1
		$I->comment("Exiting Action Group [assertProductMainInMain1] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertProductBoth1] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleCommonProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductBoth1
		$I->comment("Exiting Action Group [assertProductBoth1] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Customer log out");
		$I->comment("Entering Action Group [customerLogoutStorefront1] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogoutStorefront1
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogoutStorefront1
		$I->comment("Exiting Action Group [customerLogoutStorefront1] StorefrontCustomerLogoutActionGroup");
		$I->comment("Go to Main Website home page with Members Group customer");
		$I->comment("Entering Action Group [goToHomePage2] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage2
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage2
		$I->comment("Exiting Action Group [goToHomePage2] StorefrontOpenHomePageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad4
		$I->comment("Sign In Main Website Members Group Customer using Sign In header Link");
		$I->comment("Entering Action Group [MainWebsiteCustomerMembersGroupLogin] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->click("//header[@class='page-header']//li/a[contains(.,'Sign In')]"); // stepKey: clickSignInAccountLinkMainWebsiteCustomerMembersGroupLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedMainWebsiteCustomerMembersGroupLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsMainWebsiteCustomerMembersGroupLogin
		$I->fillField("#email", $I->retrieveEntityField('customerAssignedToMainWebsiteMembersGroup', 'email', 'test')); // stepKey: fillEmailMainWebsiteCustomerMembersGroupLogin
		$I->fillField("#pass", $I->retrieveEntityField('customerAssignedToMainWebsiteMembersGroup', 'password', 'test')); // stepKey: fillPasswordMainWebsiteCustomerMembersGroupLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonMainWebsiteCustomerMembersGroupLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonMainWebsiteCustomerMembersGroupLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInMainWebsiteCustomerMembersGroupLogin
		$I->comment("Exiting Action Group [MainWebsiteCustomerMembersGroupLogin] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->comment("Assert simpleCommonProduct and simpleMainProduct in Main Website website and Main category product grid");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createDefaultSubcategory', 'name', 'test') . "')]]"); // stepKey: goToCategoryMain2
		$I->waitForPageLoad(30); // stepKey: goToCategoryMain2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageMain2
		$I->comment("Entering Action Group [assertProductMainInMain2] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleMainProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductMainInMain2
		$I->comment("Exiting Action Group [assertProductMainInMain2] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertProductBoth2] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleCommonProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductBoth2
		$I->comment("Exiting Action Group [assertProductBoth2] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Customer log out");
		$I->comment("Entering Action Group [customerLogoutStorefront2] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogoutStorefront2
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogoutStorefront2
		$I->comment("Exiting Action Group [customerLogoutStorefront2] StorefrontCustomerLogoutActionGroup");
		$I->comment("Exclude French Website from Members group");
		$I->comment("Entering Action Group [openCustomerGroupGridPage1] AdminOpenCustomerGroupsGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/"); // stepKey: goToAdminCustomerGroupIndexPageOpenCustomerGroupGridPage1
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupIndexPageLoadOpenCustomerGroupGridPage1
		$I->comment("Exiting Action Group [openCustomerGroupGridPage1] AdminOpenCustomerGroupsGridPageActionGroup");
		$I->comment("Entering Action Group [filterCustomerGroupsByMembersGroup] AdminFilterCustomerGroupByNameActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageFilterCustomerGroupsByMembersGroup
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageFilterCustomerGroupsByMembersGroupWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterCustomerGroupsByMembersGroup
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterCustomerGroupsByMembersGroupWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", $I->retrieveEntityField('customerGroupMembers', 'code', 'test')); // stepKey: fillNameFieldOnFiltersSectionFilterCustomerGroupsByMembersGroup
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonFilterCustomerGroupsByMembersGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFilterCustomerGroupsByMembersGroupWaitForPageLoad
		$I->comment("Exiting Action Group [filterCustomerGroupsByMembersGroup] AdminFilterCustomerGroupByNameActionGroup");
		$I->comment("Entering Action Group [openMembersCustomerGroupEditPage] AdminOpenCustomerGroupEditPageFromGridActionGroup");
		$I->conditionalClick("//button[@class='action-select']", "//button[@class='action-select']", true); // stepKey: clickSelectButtonOpenMembersCustomerGroupEditPage
		$I->click("//tr[.//td[count(//th[./*[.='Group']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('customerGroupMembers', 'code', 'test') . "']]]//a[contains(@href, '/edit/')]"); // stepKey: clickOnEditCustomerGroupOpenMembersCustomerGroupEditPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupEditPageOpenMembersCustomerGroupEditPage
		$I->comment("Exiting Action Group [openMembersCustomerGroupEditPage] AdminOpenCustomerGroupEditPageFromGridActionGroup");
		$I->selectOption("#customer_group_excluded_website_ids", "Second Website" . msq("customWebsite")); // stepKey: selectFRExcludedWebsiteOption
		$I->click("#save"); // stepKey: clickToSaveCustomerGroup1
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupSaved1
		$I->see("You saved the customer group."); // stepKey: seeCustomerGroupSaveMessage1
		$I->comment("Exclude Main Website from Family group");
		$I->comment("Entering Action Group [openCustomerGroupGridPage2] AdminOpenCustomerGroupsGridPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/"); // stepKey: goToAdminCustomerGroupIndexPageOpenCustomerGroupGridPage2
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupIndexPageLoadOpenCustomerGroupGridPage2
		$I->comment("Exiting Action Group [openCustomerGroupGridPage2] AdminOpenCustomerGroupsGridPageActionGroup");
		$I->comment("Entering Action Group [filterCustomerGroupsByFamilyGroup] AdminFilterCustomerGroupByNameActionGroup");
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageFilterCustomerGroupsByFamilyGroup
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageFilterCustomerGroupsByFamilyGroupWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetFilterCustomerGroupsByFamilyGroup
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetFilterCustomerGroupsByFamilyGroupWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", $I->retrieveEntityField('customerGroupFamily', 'code', 'test')); // stepKey: fillNameFieldOnFiltersSectionFilterCustomerGroupsByFamilyGroup
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonFilterCustomerGroupsByFamilyGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonFilterCustomerGroupsByFamilyGroupWaitForPageLoad
		$I->comment("Exiting Action Group [filterCustomerGroupsByFamilyGroup] AdminFilterCustomerGroupByNameActionGroup");
		$I->comment("Entering Action Group [openFamilyCustomerGroupEditPage] AdminOpenCustomerGroupEditPageFromGridActionGroup");
		$I->conditionalClick("//button[@class='action-select']", "//button[@class='action-select']", true); // stepKey: clickSelectButtonOpenFamilyCustomerGroupEditPage
		$I->click("//tr[.//td[count(//th[./*[.='Group']]/preceding-sibling::th) + 1][./*[.='" . $I->retrieveEntityField('customerGroupFamily', 'code', 'test') . "']]]//a[contains(@href, '/edit/')]"); // stepKey: clickOnEditCustomerGroupOpenFamilyCustomerGroupEditPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupEditPageOpenFamilyCustomerGroupEditPage
		$I->comment("Exiting Action Group [openFamilyCustomerGroupEditPage] AdminOpenCustomerGroupEditPageFromGridActionGroup");
		$I->selectOption("#customer_group_excluded_website_ids", "Main Website"); // stepKey: selectMainExcludedWebsiteOption
		$I->click("#save"); // stepKey: clickToSaveCustomerGroup2
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupSaved2
		$I->see("You saved the customer group."); // stepKey: seeCustomerGroupSaveMessage2
		$I->comment("Go to FR website home page as NOT LOGGED IN user");
		$I->amOnPage("$grabStoreViewCode"); // stepKey: navigateToHomePageOfFRStore3
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad5
		$I->comment("Assert simpleCommonProduct and simpleFrenchProduct in FR website and FR category product grid");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createFrenchSubcategory', 'name', 'test') . "')]]"); // stepKey: goToCategoryFR3
		$I->waitForPageLoad(30); // stepKey: goToCategoryFR3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageFR3
		$I->comment("Entering Action Group [assertProductFRInFR3] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleFrenchProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductFRInFR3
		$I->comment("Exiting Action Group [assertProductFRInFR3] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertProductBothInUS_FR3] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleCommonProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductBothInUS_FR3
		$I->comment("Exiting Action Group [assertProductBothInUS_FR3] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Sign In FR Website as Family Group Customer");
		$I->comment("Entering Action Group [FrCustomerFamilyGroupLogin2] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->click("//header[@class='page-header']//li/a[contains(.,'Sign In')]"); // stepKey: clickSignInAccountLinkFrCustomerFamilyGroupLogin2
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedFrCustomerFamilyGroupLogin2
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsFrCustomerFamilyGroupLogin2
		$I->fillField("#email", $I->retrieveEntityField('customerAssignedToFrenchWebsiteFamilyGroup', 'email', 'test')); // stepKey: fillEmailFrCustomerFamilyGroupLogin2
		$I->fillField("#pass", $I->retrieveEntityField('customerAssignedToFrenchWebsiteFamilyGroup', 'password', 'test')); // stepKey: fillPasswordFrCustomerFamilyGroupLogin2
		$I->click("#send2"); // stepKey: clickSignInAccountButtonFrCustomerFamilyGroupLogin2
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonFrCustomerFamilyGroupLogin2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInFrCustomerFamilyGroupLogin2
		$I->comment("Exiting Action Group [FrCustomerFamilyGroupLogin2] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->comment("Assert simpleCommonProduct and simpleFrenchProduct in FR website and FR category product grid");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createFrenchSubcategory', 'name', 'test') . "')]]"); // stepKey: goToCategoryFR4
		$I->waitForPageLoad(30); // stepKey: goToCategoryFR4WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageFR4
		$I->comment("Entering Action Group [assertProductFRInFR4] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleFrenchProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductFRInFR4
		$I->comment("Exiting Action Group [assertProductFRInFR4] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertProductBothInUS_FR4] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleCommonProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductBothInUS_FR4
		$I->comment("Exiting Action Group [assertProductBothInUS_FR4] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Customer log out");
		$I->comment("Entering Action Group [storefrontSignOut3] StorefrontCustomStoreCustomerLogoutActionGroup");
		$I->amOnPage("/fr" . msq("customStoreFR") . "/customer/account/logout/"); // stepKey: storefrontSignOutStorefrontSignOut3
		$I->waitForPageLoad(30); // stepKey: waitForSignOutStorefrontSignOut3
		$I->comment("Exiting Action Group [storefrontSignOut3] StorefrontCustomStoreCustomerLogoutActionGroup");
		$I->comment("Go to FR website home page");
		$I->amOnPage("$grabStoreViewCode"); // stepKey: navigateToHomePageOfFRStore4
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad6
		$I->comment("Sign In FR Website as Members Group customer");
		$I->comment("Entering Action Group [FrCustomerMembersGroupLogin2] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->click("//header[@class='page-header']//li/a[contains(.,'Sign In')]"); // stepKey: clickSignInAccountLinkFrCustomerMembersGroupLogin2
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedFrCustomerMembersGroupLogin2
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsFrCustomerMembersGroupLogin2
		$I->fillField("#email", $I->retrieveEntityField('customerAssignedToFrenchWebsiteMembersGroup', 'email', 'test')); // stepKey: fillEmailFrCustomerMembersGroupLogin2
		$I->fillField("#pass", $I->retrieveEntityField('customerAssignedToFrenchWebsiteMembersGroup', 'password', 'test')); // stepKey: fillPasswordFrCustomerMembersGroupLogin2
		$I->click("#send2"); // stepKey: clickSignInAccountButtonFrCustomerMembersGroupLogin2
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonFrCustomerMembersGroupLogin2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInFrCustomerMembersGroupLogin2
		$I->comment("Exiting Action Group [FrCustomerMembersGroupLogin2] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->comment("Assert that customer is excluded from Members customer group");
		$I->comment("Entering Action Group [seeErrorMessageAfterLogin] AssertMessageCustomerLoginActionGroup");
		$I->see("This website is excluded from customer's group.", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterLogin
		$I->comment("Exiting Action Group [seeErrorMessageAfterLogin] AssertMessageCustomerLoginActionGroup");
		$I->comment("Go to Main Website home page with Members Group customer");
		$I->comment("Entering Action Group [goToHomePage3] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage3
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage3
		$I->comment("Exiting Action Group [goToHomePage3] StorefrontOpenHomePageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad7
		$I->comment("Sign In Main Website as Members Group Customer");
		$I->comment("Entering Action Group [MainWebsiteCustomerMembersGroupLogin2] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->click("//header[@class='page-header']//li/a[contains(.,'Sign In')]"); // stepKey: clickSignInAccountLinkMainWebsiteCustomerMembersGroupLogin2
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedMainWebsiteCustomerMembersGroupLogin2
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsMainWebsiteCustomerMembersGroupLogin2
		$I->fillField("#email", $I->retrieveEntityField('customerAssignedToMainWebsiteMembersGroup', 'email', 'test')); // stepKey: fillEmailMainWebsiteCustomerMembersGroupLogin2
		$I->fillField("#pass", $I->retrieveEntityField('customerAssignedToMainWebsiteMembersGroup', 'password', 'test')); // stepKey: fillPasswordMainWebsiteCustomerMembersGroupLogin2
		$I->click("#send2"); // stepKey: clickSignInAccountButtonMainWebsiteCustomerMembersGroupLogin2
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonMainWebsiteCustomerMembersGroupLogin2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInMainWebsiteCustomerMembersGroupLogin2
		$I->comment("Exiting Action Group [MainWebsiteCustomerMembersGroupLogin2] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->comment("Assert simpleCommonProduct and simpleMainProduct in Main Website website and Main category product grid");
		$I->click("//nav//a[span[contains(., '" . $I->retrieveEntityField('createDefaultSubcategory', 'name', 'test') . "')]]"); // stepKey: goToCategoryMain3
		$I->waitForPageLoad(30); // stepKey: goToCategoryMain3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageMain4
		$I->comment("Entering Action Group [assertProductMainInMain3] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleMainProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductMainInMain3
		$I->comment("Exiting Action Group [assertProductMainInMain3] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [assertProductBoth3] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->waitForElementVisible("//main//li//a[contains(text(), '" . $I->retrieveEntityField('simpleCommonProduct', 'name', 'test') . "')]", 30); // stepKey: assertProductNameAssertProductBoth3
		$I->comment("Exiting Action Group [assertProductBoth3] AssertStorefrontProductIsPresentOnCategoryPageActionGroup");
		$I->comment("Customer log out");
		$I->comment("Entering Action Group [customerLogoutStorefront3] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogoutStorefront3
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogoutStorefront3
		$I->comment("Exiting Action Group [customerLogoutStorefront3] StorefrontCustomerLogoutActionGroup");
		$I->comment("Go to Main Website home page with Family Group customer");
		$I->comment("Entering Action Group [goToHomePage4] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage4
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage4
		$I->comment("Exiting Action Group [goToHomePage4] StorefrontOpenHomePageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad8
		$I->comment("Sign In Main Website as Family Group Customer");
		$I->comment("Entering Action Group [MainWebsiteCustomerFamilyGroupLogin2] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->click("//header[@class='page-header']//li/a[contains(.,'Sign In')]"); // stepKey: clickSignInAccountLinkMainWebsiteCustomerFamilyGroupLogin2
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedMainWebsiteCustomerFamilyGroupLogin2
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsMainWebsiteCustomerFamilyGroupLogin2
		$I->fillField("#email", $I->retrieveEntityField('customerAssignedToMainWebsiteFamilyGroup', 'email', 'test')); // stepKey: fillEmailMainWebsiteCustomerFamilyGroupLogin2
		$I->fillField("#pass", $I->retrieveEntityField('customerAssignedToMainWebsiteFamilyGroup', 'password', 'test')); // stepKey: fillPasswordMainWebsiteCustomerFamilyGroupLogin2
		$I->click("#send2"); // stepKey: clickSignInAccountButtonMainWebsiteCustomerFamilyGroupLogin2
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonMainWebsiteCustomerFamilyGroupLogin2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInMainWebsiteCustomerFamilyGroupLogin2
		$I->comment("Exiting Action Group [MainWebsiteCustomerFamilyGroupLogin2] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->comment("Assert that customer is excluded from Family customer group");
		$I->comment("Entering Action Group [seeErrorMessageAfterLogin2] AssertMessageCustomerLoginActionGroup");
		$I->see("This website is excluded from customer's group.", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterLogin2
		$I->comment("Exiting Action Group [seeErrorMessageAfterLogin2] AssertMessageCustomerLoginActionGroup");
		$I->comment("Login to the Main Website as FR customer");
		$I->comment("Entering Action Group [goToHomePage5] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage5
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage5
		$I->comment("Exiting Action Group [goToHomePage5] StorefrontOpenHomePageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForHomePageLoad9
		$I->comment("Sign In Main Website as FR Members Group Customer");
		$I->comment("Entering Action Group [MainWebsiteCustomerMembersGroupLogin3] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->click("//header[@class='page-header']//li/a[contains(.,'Sign In')]"); // stepKey: clickSignInAccountLinkMainWebsiteCustomerMembersGroupLogin3
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedMainWebsiteCustomerMembersGroupLogin3
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsMainWebsiteCustomerMembersGroupLogin3
		$I->fillField("#email", $I->retrieveEntityField('customerAssignedToFrenchWebsiteMembersGroup', 'email', 'test')); // stepKey: fillEmailMainWebsiteCustomerMembersGroupLogin3
		$I->fillField("#pass", $I->retrieveEntityField('customerAssignedToFrenchWebsiteMembersGroup', 'password', 'test')); // stepKey: fillPasswordMainWebsiteCustomerMembersGroupLogin3
		$I->click("#send2"); // stepKey: clickSignInAccountButtonMainWebsiteCustomerMembersGroupLogin3
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonMainWebsiteCustomerMembersGroupLogin3WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInMainWebsiteCustomerMembersGroupLogin3
		$I->comment("Exiting Action Group [MainWebsiteCustomerMembersGroupLogin3] StorefrontLoginAsCustomerUsingHeaderSignInLinkActionGroup");
		$I->comment("Assert that customer cannot login");
		$I->comment("Entering Action Group [seeErrorMessageAfterLogin3] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterLogin3
		$I->comment("Exiting Action Group [seeErrorMessageAfterLogin3] AssertMessageCustomerLoginActionGroup");
	}
}
