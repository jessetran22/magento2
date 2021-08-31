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
 * @Title("MC-14208: Clear all products from the 'Compare Products' list")
 * @Description("You should be able to remove all Products in the 'Compare Products' list.<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontClearAllCompareProductsTest.xml<br>")
 * @TestCaseId("MC-14208")
 * @group catalog
 * @group mtf_migrated
 */
class StorefrontClearAllCompareProductsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$addDownloadableDomain = $I->magentoCLI("downloadable:domains:add static.magento.com", 60); // stepKey: addDownloadableDomain
		$I->comment($addDownloadableDomain);
		$I->comment("Create Simple Customer");
		$I->createEntity("createSimpleCustomer1", "hook", "Simple_US_Customer_CA", [], []); // stepKey: createSimpleCustomer1
		$I->comment("Create Simple Category");
		$I->createEntity("createSimpleCategory1", "hook", "SimpleSubCategory", [], []); // stepKey: createSimpleCategory1
		$I->comment("Create Simple Products");
		$I->createEntity("createSimpleProduct1", "hook", "SimpleProduct", ["createSimpleCategory1"], []); // stepKey: createSimpleProduct1
		$I->createEntity("createSimpleProduct2", "hook", "SimpleProduct", ["createSimpleCategory1"], []); // stepKey: createSimpleProduct2
		$I->comment("Create Configurable Product");
		$I->createEntity("createConfigProduct1", "hook", "ApiConfigurableProduct", ["createSimpleCategory1"], []); // stepKey: createConfigProduct1
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->getEntity("getConfigAttributeOption", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption
		$I->createEntity("createConfigChildProduct", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption", "createSimpleCategory1"], []); // stepKey: createConfigChildProduct
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductTwoOptions", ["createConfigProduct1", "createConfigProductAttribute", "getConfigAttributeOption"], []); // stepKey: createConfigProductOption
		$I->createEntity("createConfigProductAddChild", "hook", "ConfigurableProductAddChild", ["createConfigProduct1", "createConfigChildProduct"], []); // stepKey: createConfigProductAddChild
		$I->comment("Create Virtual Product");
		$I->createEntity("createVirtualProduct1", "hook", "VirtualProduct", ["createSimpleCategory1"], []); // stepKey: createVirtualProduct1
		$I->comment("Create Bundled Product");
		$I->createEntity("createBundleProduct1", "hook", "ApiBundleProduct", ["createSimpleCategory1"], []); // stepKey: createBundleProduct1
		$I->createEntity("createBundleOption1", "hook", "DropDownBundleOption", ["createBundleProduct1"], []); // stepKey: createBundleOption1
		$createBundleLink1Fields['qty'] = "10";
		$I->createEntity("createBundleLink1", "hook", "ApiBundleLink", ["createBundleProduct1", "createBundleOption1", "createSimpleProduct1"], $createBundleLink1Fields); // stepKey: createBundleLink1
		$I->comment("Create Grouped Product");
		$I->createEntity("createGroupedProduct1", "hook", "ApiGroupedProduct2", ["createSimpleCategory1"], []); // stepKey: createGroupedProduct1
		$I->createEntity("addFirstProduct1", "hook", "OneSimpleProductLink", ["createGroupedProduct1", "createSimpleProduct1"], []); // stepKey: addFirstProduct1
		$I->updateEntity("addFirstProduct1", "hook", "OneMoreSimpleProductLink",["createGroupedProduct1", "createSimpleProduct2"]); // stepKey: addSecondProduct1
		$I->comment("Create Downloadable Product");
		$I->createEntity("createDownloadableProduct1", "hook", "ApiDownloadableProduct", [], []); // stepKey: createDownloadableProduct1
		$I->createEntity("addDownloadableLink1", "hook", "ApiDownloadableLink", ["createDownloadableProduct1"], []); // stepKey: addDownloadableLink1
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Login");
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$removeDownloadableDomain = $I->magentoCLI("downloadable:domains:remove static.magento.com", 60); // stepKey: removeDownloadableDomain
		$I->comment($removeDownloadableDomain);
		$I->comment("Logout");
		$I->comment("Entering Action Group [logoutOfAdmin1] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin1
		$I->comment("Exiting Action Group [logoutOfAdmin1] AdminLogoutActionGroup");
		$I->comment("Delete Created Entities");
		$I->deleteEntity("createSimpleCustomer1", "hook"); // stepKey: deleteSimpleCustomer1
		$I->deleteEntity("createSimpleCategory1", "hook"); // stepKey: deleteSimpleCategory1
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("createConfigChildProduct", "hook"); // stepKey: deleteConfigChildProduct
		$I->deleteEntity("createConfigProduct1", "hook"); // stepKey: deleteConfigProduct1
		$I->deleteEntity("createVirtualProduct1", "hook"); // stepKey: deleteVirtualProduct1
		$I->deleteEntity("createBundleProduct1", "hook"); // stepKey: deleteBundleProduct1
		$I->deleteEntity("createGroupedProduct1", "hook"); // stepKey: deleteGroupedProduct1
		$I->deleteEntity("createDownloadableProduct1", "hook"); // stepKey: deleteDownloadableProduct1
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteConfigProductAttribute
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Compare Products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontClearAllCompareProductsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsCustomer1] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer1
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer1
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer1
		$I->fillField("#email", $I->retrieveEntityField('createSimpleCustomer1', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer1
		$I->fillField("#pass", $I->retrieveEntityField('createSimpleCustomer1', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer1
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer1
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomer1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer1
		$I->comment("Exiting Action Group [loginAsCustomer1] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [openProductPage1] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage1
		$I->comment("Exiting Action Group [openProductPage1] StorefrontOpenProductPageActionGroup");
		$I->scrollTo("a.action.tocompare"); // stepKey: scrollToCompareProductButton1
		$I->comment("Entering Action Group [addProductToCompare1] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAddProductToCompare1
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAddProductToCompare1
		$I->see("You added product " . $I->retrieveEntityField('createSimpleProduct1', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAddProductToCompare1
		$I->comment("Exiting Action Group [addProductToCompare1] StorefrontAddProductToCompareActionGroup");
		$I->comment("Entering Action Group [openProductPage2] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createConfigProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage2
		$I->comment("Exiting Action Group [openProductPage2] StorefrontOpenProductPageActionGroup");
		$I->scrollTo("a.action.tocompare"); // stepKey: scrollToCompareProductButton2
		$I->comment("Entering Action Group [addProductToCompare2] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAddProductToCompare2
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAddProductToCompare2
		$I->see("You added product " . $I->retrieveEntityField('createConfigProduct1', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAddProductToCompare2
		$I->comment("Exiting Action Group [addProductToCompare2] StorefrontAddProductToCompareActionGroup");
		$I->comment("Entering Action Group [openProductPage3] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createVirtualProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage3
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage3
		$I->comment("Exiting Action Group [openProductPage3] StorefrontOpenProductPageActionGroup");
		$I->scrollTo("a.action.tocompare"); // stepKey: scrollToCompareProductButton3
		$I->comment("Entering Action Group [addProductToCompare3] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAddProductToCompare3
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAddProductToCompare3
		$I->see("You added product " . $I->retrieveEntityField('createVirtualProduct1', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAddProductToCompare3
		$I->comment("Exiting Action Group [addProductToCompare3] StorefrontAddProductToCompareActionGroup");
		$I->comment("Entering Action Group [openProductPage4] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage4
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage4
		$I->comment("Exiting Action Group [openProductPage4] StorefrontOpenProductPageActionGroup");
		$I->scrollTo("a.action.tocompare"); // stepKey: scrollToCompareProductButton4
		$I->comment("Entering Action Group [addProductToCompare4] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAddProductToCompare4
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAddProductToCompare4
		$I->see("You added product " . $I->retrieveEntityField('createBundleProduct1', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAddProductToCompare4
		$I->comment("Exiting Action Group [addProductToCompare4] StorefrontAddProductToCompareActionGroup");
		$I->comment("Entering Action Group [openProductPage5] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createGroupedProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage5
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage5
		$I->comment("Exiting Action Group [openProductPage5] StorefrontOpenProductPageActionGroup");
		$I->scrollTo("a.action.tocompare"); // stepKey: scrollToCompareProductButton5
		$I->comment("Entering Action Group [addProductToCompare5] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAddProductToCompare5
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAddProductToCompare5
		$I->see("You added product " . $I->retrieveEntityField('createGroupedProduct1', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAddProductToCompare5
		$I->comment("Exiting Action Group [addProductToCompare5] StorefrontAddProductToCompareActionGroup");
		$I->comment("Entering Action Group [openProductPage6] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createDownloadableProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage6
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage6
		$I->comment("Exiting Action Group [openProductPage6] StorefrontOpenProductPageActionGroup");
		$I->scrollTo("a.action.tocompare"); // stepKey: scrollToCompareProductButton6
		$I->comment("Entering Action Group [addProductToCompare6] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAddProductToCompare6
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAddProductToCompare6
		$I->see("You added product " . $I->retrieveEntityField('createDownloadableProduct1', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAddProductToCompare6
		$I->comment("Exiting Action Group [addProductToCompare6] StorefrontAddProductToCompareActionGroup");
		$I->comment("Entering Action Group [amOnMyAccountDashboard1] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageAmOnMyAccountDashboard1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAmOnMyAccountDashboard1
		$I->comment("Exiting Action Group [amOnMyAccountDashboard1] StorefrontOpenMyAccountPageActionGroup");
		$I->comment("Entering Action Group [clearComparedProducts1] StorefrontClearCompareActionGroup");
		$I->waitForElementVisible("//main//div[contains(@class, 'block-compare')]//a[contains(@class, 'action clear')]", 30); // stepKey: waitForClearAllClearComparedProducts1
		$I->click("//main//div[contains(@class, 'block-compare')]//a[contains(@class, 'action clear')]"); // stepKey: clickClearAllClearComparedProducts1
		$I->waitForElementVisible("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]", 30); // stepKey: waitForClearOkClearComparedProducts1
		$I->waitForPageLoad(30); // stepKey: waitForClearOkClearComparedProducts1WaitForPageLoad
		$I->scrollTo("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: scrollToClearOkClearComparedProducts1
		$I->waitForPageLoad(30); // stepKey: scrollToClearOkClearComparedProducts1WaitForPageLoad
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: clickClearOkClearComparedProducts1
		$I->waitForPageLoad(30); // stepKey: clickClearOkClearComparedProducts1WaitForPageLoad
		$I->waitForElementVisible("//main//div[contains(@class, 'messages')]//div[contains(@class, 'message')]/div[contains(text(), 'You cleared the comparison list.')]", 30); // stepKey: assertMessageClearedClearComparedProducts1
		$I->waitForElementVisible("//main//div[contains(@class, 'block-compare')]//div[@class='empty']", 30); // stepKey: assertNoItemsClearComparedProducts1
		$I->comment("Exiting Action Group [clearComparedProducts1] StorefrontClearCompareActionGroup");
	}
}
