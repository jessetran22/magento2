<?php
namespace Magento\AcceptanceTest\_MediaGalleryUiSuite\Backend;

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
 * @Title("https://studio.cucumber.io/projects/131313/test-plan/folders/1507933/scenarios/5200023: DEPRECATED. Admin user should see correct image file size after rendition")
 * @TestCaseId("https://studio.cucumber.io/projects/131313/test-plan/folders/1507933/scenarios/5200023")
 * @Description("Admin user should see correct image file size after rendition<h3 class='y-label y-label_status_broken'>Deprecated Notice(s):</h3><ul><li>Use AdminMediaGalleryInsertImageLargeFileSizeTest instead</li></ul><h3>Test files</h3>app/code/Magento/MediaGalleryRenditions/Test/Mftf/Test/AdminMediaGalleryInsertLargeImageFileSizeTest.xml<br>")
 * @group media_gallery_ui
 */
class AdminMediaGalleryInsertLargeImageFileSizeTestCest
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
        $this->helperContainer->create("Magento\MediaGalleryUi\Test\Mftf\Helper\MediaGalleryUiHelper");
    }
	/**
	 * @Features({"MediaGalleryRenditions"})
	 * @Stories({"User inserts image rendition to the content"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminMediaGalleryInsertLargeImageFileSizeTest(AcceptanceTester $I, \Codeception\Scenario $scenario)
	{
		$scenario->skip("This test is skipped due to the following issues:\nUse AdminMediaGalleryInsertImageLargeFileSizeTest instead");
	}
}
